<?php
namespace app\Helpers;

use ZipArchive;
use SimpleXMLElement;

class ExcelHelper {

    /**
     * Membaca file baik format Excel (.xlsx) maupun CSV (.csv)
     * Mengembalikan array baris data [[col0, col1, col2, ...], ...]
     *
     * @param string $filePath Path file di filesystem
     * @param string $originalName Nama file asli untuk deteksi ekstensi
     * @return array|false
     */
    public static function parseRows($filePath, $originalName) {
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if ($ext === 'xlsx') {
            return self::parseXlsx($filePath);
        } elseif (in_array($ext, ['csv', 'txt'], true)) {
            return self::parseCsv($filePath);
        }

        return false;
    }

    /**
     * Membaca file Microsoft Excel (.xlsx) menggunakan ZipArchive dan XML parser bawaan PHP.
     * Tidak membutuhkan library pihak ketiga / composer.
     */
    public static function parseXlsx($filePath) {
        if (!class_exists('ZipArchive')) {
            return false;
        }

        $zip = new ZipArchive();
        if ($zip->open($filePath) !== true) {
            return false;
        }

        // 1. Baca shared strings jika tersedia
        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXml !== false) {
            $xml = @simplexml_load_string($sharedStringsXml);
            if ($xml && isset($xml->si)) {
                foreach ($xml->si as $si) {
                    if (isset($si->t)) {
                        $sharedStrings[] = (string)$si->t;
                    } elseif (isset($si->r)) {
                        $text = '';
                        foreach ($si->r as $r) {
                            $text .= (string)$r->t;
                        }
                        $sharedStrings[] = $text;
                    } else {
                        $sharedStrings[] = '';
                    }
                }
            }
        }

        // 2. Baca worksheet pertama (sheet1.xml atau lembar pertama yang ditemukan)
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if ($sheetXml === false) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (strpos($name, 'xl/worksheets/sheet') === 0 && substr($name, -4) === '.xml') {
                    $sheetXml = $zip->getFromName($name);
                    break;
                }
            }
        }
        $zip->close();

        if ($sheetXml === false) {
            return false;
        }

        $xml = @simplexml_load_string($sheetXml);
        if (!$xml || !isset($xml->sheetData)) {
            return false;
        }

        $rows = [];
        foreach ($xml->sheetData->row as $row) {
            $rowData = [];
            foreach ($row->c as $c) {
                $ref = (string)$c['r'];
                preg_match('/^([A-Z]+)(\d+)$/', $ref, $m);
                $colLetters = $m[1] ?? 'A';

                // Hitung index kolom (A=0, B=1, ... Z=25, AA=26)
                $colIndex = 0;
                for ($k = 0; $k < strlen($colLetters); $k++) {
                    $colIndex = $colIndex * 26 + (ord($colLetters[$k]) - ord('A') + 1);
                }
                $colIndex -= 1;

                $type = (string)$c['t'];
                $val = '';
                if ($type === 's') { // Shared string index
                    $idx = (int)$c->v;
                    $val = $sharedStrings[$idx] ?? '';
                } elseif ($type === 'inlineStr' && isset($c->is->t)) {
                    $val = (string)$c->is->t;
                } elseif (isset($c->v)) {
                    $val = (string)$c->v;
                }

                $rowData[$colIndex] = trim($val);
            }

            if (!empty($rowData)) {
                ksort($rowData);
                $maxCol = max(array_keys($rowData));
                $completeRow = [];
                for ($j = 0; $j <= $maxCol; $j++) {
                    $completeRow[$j] = $rowData[$j] ?? '';
                }
                $rows[] = $completeRow;
            }
        }

        return $rows;
    }

    /**
     * Membaca file CSV dengan auto-detect delimiter (koma atau titik-koma)
     */
    public static function parseCsv($filePath) {
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            return false;
        }

        $firstLine = fgets($handle);
        rewind($handle);

        $delimiter = ',';
        if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
            $delimiter = ';';
        }

        $rows = [];
        while (($row = fgetcsv($handle, 4096, $delimiter)) !== false) {
            $cleanRow = array_map(function($val) {
                return preg_replace('/^\xEF\xBB\xBF/', '', trim((string)$val));
            }, $row);

            if (!empty(array_filter($cleanRow, fn($v) => $v !== ''))) {
                $rows[] = $cleanRow;
            }
        }
        fclose($handle);

        return $rows;
    }

    /**
     * Menghasilkan file Excel .xlsx asli untuk template import data anggota
     */
    public static function streamTemplateXlsx($filename = 'template_data_anggota_fkmtg.xlsx') {
        $tempFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        $zip = new ZipArchive();
        if ($zip->open($tempFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return false;
        }

        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
    <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
    <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedString+xml"/>
</Types>';

        $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>';

        $wbRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
</Relationships>';

        $workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <sheets>
        <sheet name="Data Anggota" sheetId="1" r:id="rId1"/>
    </sheets>
</workbook>';

        $headers = [
            'Nama Lengkap', 'Asal Kampus', 'Fakultas', 'Jurusan', 'Tahun Angkatan', 'Nomor WhatsApp', 'Email', 'Golongan Darah', 'Alamat Domisili'
        ];
        $sample1 = [
            'Ahmad Fauzi', 'Universitas Negeri Gorontalo', 'Fakultas Teknik', 'Teknik Informatika', '2022', '081234567890', 'ahmad.fauzi@gmail.com', 'O', 'Jl. Trans Sulawesi, Toili'
        ];
        $sample2 = [
            'Siti Nurhaliza', 'IAIN Sultan Amai Gorontalo', 'Fakultas Tarbiyah', 'Pendidikan Agama Islam', '2023', '085298765432', 'siti.nur@gmail.com', 'A', 'Desa Mansahang, Kec. Toili'
        ];

        $allStrings = array_merge($headers, $sample1, $sample2);
        $sst = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . count($allStrings) . '" uniqueCount="' . count($allStrings) . '">';
        foreach ($allStrings as $str) {
            $sst .= '<si><t>' . htmlspecialchars($str, ENT_XML1, 'UTF-8') . '</t></si>';
        }
        $sst .= '</sst>';

        // Buat sheet1.xml
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        $sheet = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
    <cols>
        <col min="1" max="1" width="26" customWidth="1"/>
        <col min="2" max="2" width="30" customWidth="1"/>
        <col min="3" max="3" width="22" customWidth="1"/>
        <col min="4" max="4" width="24" customWidth="1"/>
        <col min="5" max="5" width="16" customWidth="1"/>
        <col min="6" max="6" width="18" customWidth="1"/>
        <col min="7" max="7" width="26" customWidth="1"/>
        <col min="8" max="8" width="16" customWidth="1"/>
        <col min="9" max="9" width="30" customWidth="1"/>
    </cols>
    <sheetData>
        <row r="1">';
        for ($i = 0; $i < count($headers); $i++) {
            $sheet .= '<c r="' . $cols[$i] . '1" t="s"><v>' . $i . '</v></c>';
        }
        $sheet .= '</row><row r="2">';
        for ($i = 0; $i < count($sample1); $i++) {
            $sheet .= '<c r="' . $cols[$i] . '2" t="s"><v>' . ($i + 9) . '</v></c>';
        }
        $sheet .= '</row><row r="3">';
        for ($i = 0; $i < count($sample2); $i++) {
            $sheet .= '<c r="' . $cols[$i] . '3" t="s"><v>' . ($i + 18) . '</v></c>';
        }
        $sheet .= '</row>
    </sheetData>
</worksheet>';

        $zip->addFromString('[Content_Types].xml', $contentTypes);
        $zip->addFromString('_rels/.rels', $rels);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $wbRels);
        $zip->addFromString('xl/workbook.xml', $workbook);
        $zip->addFromString('xl/sharedStrings.xml', $sst);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheet);
        $zip->close();

        // Stream file ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($tempFile));
        header('Pragma: no-cache');
        header('Expires: 0');

        readfile($tempFile);
        @unlink($tempFile);
        exit;
    }
}
