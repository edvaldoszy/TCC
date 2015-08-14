<?php

namespace Szy\File;

class FileSystem
{
    public static function chmod(File $file, $mode)
    {
        return @chmod($file->getPath(), $mode);
    }

    public static function chown(File $file, $user )
    {
        return @chown($file->getPath(), $user);
    }

    public static function mkdir($path, $mode = 0777, $recursive = false)
    {
        return @mkdir($path, $mode, $recursive);
    }

    public static function rmdir($path)
    {
        return @rmdir($path);
    }

    public static function exists(File $file)
    {
        return @file_exists($file->getPath());
    }

    public static function copy(File $file, $newname)
    {
        return @copy($file->getPath(), $newname);
    }

    public static function rename(File $file, $newname)
    {
        return @rename($file->getPath(), $newname);
    }

    public static function delete(File $file)
    {
        return @unlink($file->getPath());
    }

    public static function fileSize(File $file)
    {
        return @filesize($file->getPath());
    }

    public static function fileOwner(File $file)
    {
        return @fileowner($file->getPath());
    }

    public static function fileGroup(File $file)
    {
        return @filegroup($file->getPath());
    }

    public static function fileLastModified(File $file)
    {
        return @filemtime($file->getPath());
    }

    public static function chdir($path)
    {
        return @chdir($path);
    }

    public static function isFile($path)
    {
        return @is_file($path);
    }

    public static function getSeparator()
    {
        return DIRECTORY_SEPARATOR;
    }
}