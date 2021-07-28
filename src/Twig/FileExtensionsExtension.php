<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FileExtensionsExtension extends AbstractExtension
{
    // public function getFilters(): array
    // {
    //     return [
    //         // If your filter generates SAFE HTML, you should add a third
    //         // parameter: ['is_safe' => ['html']]
    //         // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
    //         new TwigFilter('filter_name', [$this, 'doSomething']),
    //     ];
    // }
    const PDF_EXTENSION             = ['pdf'];
    const OFFICE_WORD_EXTENSION     = ['doc', 'docx'];
    const OFFICE_EXCEL_EXTENSION    = ['xls', 'xlsx', 'csv'];
    const IMAGES_EXTENSION          = ['jpeg', 'jpg', 'png', 'gif'];
    const ARCHIVE_EXTENSION         = ['zip', 'rar', 'docx', 'tarz', 'tar'];
    const DOCUMENT_EXTENSION        = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv'];

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getExtension', [$this, 'getExtension']),
            new TwigFunction('verifyExtension', [$this, 'verifyExtension']),
            new TwigFunction('isFileTypeoff', [$this, 'isFileType']),
            new TwigFunction('getFileIcon', [$this, 'getFileIcon']),
        ];
    }

    public function getExtension($filepath)
    {
        $extension = pathinfo($filepath, PATHINFO_EXTENSION);
        return strtolower($extension);
    }

    public function verifyExtension($filepath, array $extensions): bool
    {
        $fileExtension = strtolower($this->getExtension($filepath));

        $formatedExtension = [];

        foreach ($extensions as $extension) {
            $formatedExtension[] = strtolower($extension);
        }

        return in_array($fileExtension, $formatedExtension);
    }

    public function isFileType(string $fileType, $filepath): bool
    {
        switch ($fileType) {
            case 'image':
                $allowedExtension = self::IMAGES_EXTENSION;
                break;
            case 'pdf':
                $allowedExtension = self::PDF_EXTENSION;
                break;
            case 'office_word':
                $allowedExtension = self::OFFICE_WORD_EXTENSION;
                break;
            case 'office_excel':
                $allowedExtension = self::OFFICE_EXCEL_EXTENSION;
                break;
            case 'document':
                $allowedExtension = self::DOCUMENT_EXTENSION;
                break;
            case 'archive':
                $allowedExtension = self::ARCHIVE_EXTENSION;
                break;
        }

        return $this->verifyExtension($filepath, $allowedExtension);
    }

    public function getFileIcon(string $fileExtension): string
    {
        if ($this->verifyExtension($fileExtension, self::IMAGES_EXTENSION)) {
            return 'fas fa-file-image';
        }
        elseif($this->verifyExtension($fileExtension, self::PDF_EXTENSION)) {
            return 'fas fa-file-pdf';
        }
        elseif($this->verifyExtension($fileExtension, self::OFFICE_WORD_EXTENSION)) {
            return 'fas fa-file-word';
        }
        elseif($this->verifyExtension($fileExtension, self::OFFICE_EXCEL_EXTENSION)) {
            return 'fas fa-file-excel';
        }
        elseif($this->verifyExtension($fileExtension, self::ARCHIVE_EXTENSION)) {
            return 'fas fa-file-archive';
        }

        return 'fas fa-file';
    }
}
