<?php

namespace PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\Shared\XMLWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RelsVBA extends WriterPart
{
    /**
     * Write relationships for a signed VBA Project.
     *
     * @return string XML Output
     */
    public function writeVBARelationships(Spreadsheet $spreadsheet)
    {
        // Create XML writer
        $objWriter = null;
        if ($this->getParentWriter()->getUseDiskCaching()) {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_DISK, $this->getParentWriter()->getDiskCachingDirectory());
        } else {
            $objWriter = new XMLWriter(XMLWriter::STORAGE_MEMORY);
        }

        // XML header
        $objWriter->startDocument('1.0', 'UTF-8', 'yes');

        // Relationships
        $objWriter->startElement('Relationships');
        $objWriter->writeAttribute('xmlns', 'http://schemas.openxmlformats.org/package/2006/relationships');
        $objWriter->startElement('Relationship');
        $objWriter->writeAttribute('Id', 'rId1');
        // не ошибка так как описывает формат документа для Microsoft Office в виде xml тегов
        // appchecker CWE-798
        $objWriter->writeAttribute('Type', 'http://schemas.microsoft.com/office/2006/relationships/vbaProjectSignature');
        $objWriter->writeAttribute('Target', 'vbaProjectSignature.bin');
        $objWriter->endElement();
        $objWriter->endElement();

        return $objWriter->getData();
    }
}
