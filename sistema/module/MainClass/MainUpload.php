<?php
/**
 * Project: O que fazer culinária
 * ==================================
 * Dev: Rafael Silva
 * Email: contato@pantoneweb.com.br
 * Phone: +55 14 9-9747-2101
 * ==================================
 */

namespace MainClass;

use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;

/**
 * Class Upload
 * @package MainClass
 */
class MainUpload extends MainController
{

    /**
     * MAX FILESIZE UPLOAD
     */
    const MAX_FILESIZE = '1MB';
    /**
     * EXTENSIONS
     */
    const EXTENSIONS = 'jpg,jpeg,JPG,JPEG,png,PNG,pfx';

    /**
     * Upload constructor.
     */
    public function __construct()
    {
        $this->setMaxFileSize(self::MAX_FILESIZE);
        $this->setExtension(self::EXTENSIONS);
    }

    /**
     * @return array
     */
    public function processUpload()
    {
        $res = array();
        $adapter = new \Zend\File\Transfer\Adapter\Http();
        $this->setValidators($adapter);
        if ($adapter->isValid($this->getFileAttr('name'))) {
            $this->setFileNameFinal($this->getFileAttr('name'));
            $this->saveUpload($adapter);
            $this->renameFile();
            $res['success'] = true;
            $res['file_name'] = $this->getFileNameFinal();
        } else {
            $messageErrors = $this->setMessageErrors($adapter);
            $messages = $this->getErrorMessages($messageErrors);
            $res['success'] = false;
            $res['error_messages'] = $messages;
        }
        return $res;
    }

    /**
     * @param $adapter
     * @return bool
     */
    private function saveUpload($adapter)
    {
        $this->setDestinationUpload($adapter);
        if ($adapter->receive($this->getFileName())) {
            return true;
        }
    }

    /**
     * @param $adapter
     */
    private function setDestinationUpload($adapter)
    {
        $path = $this->getUploadPath();
        $this->createDir($path);
        $adapter->setDestination($path);
    }

    /**
     * @param $adapter
     */
    private function setValidators($adapter)
    {
        $size = new Size(array('max' => $this->getMaxFileSize()));
        $ext = new Extension($this->getExtension());
        $adapter->setValidators(array($size, $ext), $this->getFileName());
    }

    /**
     * @param $adapter
     * @return array
     */
    private function setMessageErrors($adapter)
    {
        $dataError = $adapter->getMessages();
        $error = array();
        foreach ($dataError as $row) {
            $error[] = $row;
        }
        return $error;
    }

    /**
     * @param $file
     * @return bool
     */
    public function destroyFile($file)
    {
        $filePath = $this->getUploadPath() . $file;
        if (file_exists($filePath)) {
            return @unlink($filePath);
        }
    }

    /**
     * @param $errors
     * @return string
     */
    public function getErrorMessages($errors)
    {
        $msgs = '<h3 class="title-alert">' . ('Upload error:') . '</h3>';
        foreach ($errors as $error) {
            $msgs .= '<ul>';
            $msgs .= '<li class="alert-item">' . $error . '</li>';
            $msgs .= '</ul>';
        }
        return $msgs;
    }

    /**
     *
     */
    private function renameFile()
    {
        if ($this->renameFile == true) {
            $filePath = $this->getUploadPath() . $this->getFileAttr('name');
            $pathInfo = self::getPathInfo($filePath);
            $newName = md5(uniqid() * time()) . '.' . $pathInfo['extension'];
            $newName = mb_strtoupper($newName, 'UTF-8');
            rename($pathInfo['dirname'] . '/' . $pathInfo['basename'], $pathInfo['dirname'] . '/' . $newName);
            $this->setFileNameFinal($newName);
        }
    }

    /**
     * @return bool
     */
    public function isUploaded()
    {
        if ($this->getFileAttr('name')) {
            return true;
        }
    }

    /**
     * @param $string
     * @return mixed
     */
    static function getPathInfo($string)
    {
        /*
          # returns
          # dirname
          # basename
          # extension
          # filename
         */
        return pathinfo($string);
    }

    //    SETs AND GETs
    //  ================================================================

    /**
     * @param int $status
     */
    public function remameFile($status = 0)
    {
        $this->renameFile = $status;
    }

    /**
     * @param $path
     */
    public function setUploadPath($path)
    {
        $this->uploadPath = $path;
    }

    /**
     * @return mixed
     */
    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    /**
     * @param $file
     */
    public function setFileName($file)
    {
        $this->fileName = $file;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param $name
     */
    public function setFileNameFinal($name)
    {
        $this->fileNameFinal = $name;
    }

    /**
     * @return mixed
     */
    public function getFileNameFinal()
    {
        return $this->fileNameFinal;
    }

    /**
     * @param $size
     */
    public function setMaxFileSize($size)
    {
        $this->maxFileSize = $size;
    }

    /**
     * @return mixed
     */
    public function getMaxFileSize()
    {
        return $this->maxFileSize;
    }

    /**
     * @param $ext
     */
    public function setExtension($ext)
    {
        $this->extension = $ext;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $attr
     * @return mixed
     */
    public function getFileAttr($attr)
    {
        if (isset($this->file[$attr])) {
            return $this->file[$attr];
        }
    }

}
