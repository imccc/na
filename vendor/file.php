<?php
/**
 * 操纵文件类
 * User: 周海天
 * 
 * 例子：
 * file::createDir('a/1/2/3');                  测试建立文件夹 建一个a/1/2/3文件夹
 * file::createFile('b/1/2/3');                 测试建立文件        在b/1/2/文件夹下面建一个3文件
 * file::createFile('b/1/2/3.exe');             测试建立文件        在b/1/2/文件夹下面建一个3.exe文件
 * file::copyDir('b','d/e');                    测试复制文件夹 建立一个d/e文件夹，把b文件夹下的内容复制进去
 * file::copyFile('b/1/2/3.exe','b/b/3.exe');   测试复制文件        建立一个b/b文件夹，并把b/1/2文件夹中的3.exe文件复制进去
 * file::moveDir('a/','b/c');                   测试移动文件夹 建立一个b/c文件夹,并把a文件夹下的内容移动进去，并删除a文件夹
 * file::moveFile('b/1/2/3.exe','b/d/3.exe');   测试移动文件        建立一个b/d文件夹，并把b/1/2中的3.exe移动进去
 * file::unlinkFile('b/d/3.exe');               测试删除文件        删除b/d/3.exe文件
 * file::unlinkDir('d');                        测试删除文件夹 删除d文件夹
 *
 * --------- Add Function by sam@imccc.net ------------
 * file::listDir('.');                          遍历指定目录;
 * file::listInfo('readme.md');                 返回文件信息  数组
 * file::getEx('readme.md');                    获取文件后缀名
 * file::readFile('readme.md');                 返回内容
 * file::rename('readme.md','newreadme.md');    修改文件名
 * 
 * file::changeDirFilesCode()
 * file::changeFileCode()                       指定文件编码转换  $path 文件路径  $input_code 原始编码 $out_code 输出编码
 */
class file
{

    /**
     * 建立文件夹
     *
     * @param string $aimUrl
     * @return viod
     */
    public static function createDir($aimUrl)
    {
        $aimUrl = str_replace('', '/', $aimUrl);
        $aimDir = '';
        $arr = explode('/', $aimUrl);
        $result = true;
        foreach ($arr as $str) {
            $aimDir .= $str . '/';
            if (!file_exists($aimDir)) {
                $result = mkdir($aimDir);
            }
        }
        return $result;
    }

    /**
     * 建立文件
     *
     * @param string $aimUrl
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public static function createFile($aimUrl, $overWrite = false)
    {
        if (file_exists($aimUrl) && $overWrite == false) {
            return false;
        } elseif (file_exists($aimUrl) && $overWrite == true) {
            file::unlinkFile($aimUrl);
        }
        $aimDir = dirname($aimUrl);
        file::createDir($aimDir);
        touch($aimUrl);
        return true;
    }

    /**
     * 移动文件夹
     *
     * @param string $oldDir
     * @param string $aimDir
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public static function moveDir($oldDir, $aimDir, $overWrite = false)
    {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        $oldDir = str_replace('', '/', $oldDir);
        $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
        if (!is_dir($oldDir)) {
            return false;
        }
        if (!file_exists($aimDir)) {
            file::createDir($aimDir);
        }
        @$dirHandle = opendir($oldDir);
        if (!$dirHandle) {
            return false;
        }
        while (false !== ($file = readdir($dirHandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($oldDir . $file)) {
                file::moveFile($oldDir . $file, $aimDir . $file, $overWrite);
            } else {
                file::moveDir($oldDir . $file, $aimDir . $file, $overWrite);
            }
        }
        closedir($dirHandle);
        return rmdir($oldDir);
    }

    /**
     * 移动文件
     *
     * @param string $fileUrl
     * @param string $aimUrl
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public static function moveFile($fileUrl, $aimUrl, $overWrite = false)
    {
        if (!file_exists($fileUrl)) {
            return false;
        }
        if (file_exists($aimUrl) && $overWrite = false) {
            return false;
        } elseif (file_exists($aimUrl) && $overWrite = true) {
            file::unlinkFile($aimUrl);
        }
        $aimDir = dirname($aimUrl);
        file::createDir($aimDir);
        rename($fileUrl, $aimUrl);
        return true;
    }

    /**
     * 删除文件夹
     *
     * @param string $aimDir
     * @return boolean
     */
    public static function unlinkDir($aimDir)
    {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        if (!is_dir($aimDir)) {
            return false;
        }
        $dirHandle = opendir($aimDir);
        while (false !== ($file = readdir($dirHandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($aimDir . $file)) {
                file::unlinkFile($aimDir . $file);
            } else {
                file::unlinkDir($aimDir . $file);
            }
        }
        closedir($dirHandle);
        return rmdir($aimDir);
    }

    /**
     * 删除文件
     *
     * @param string $aimUrl
     * @return boolean
     */
    public static function unlinkFile($aimUrl)
    {
        if (file_exists($aimUrl)) {
            unlink($aimUrl);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 复制文件夹
     *
     * @param string $oldDir
     * @param string $aimDir
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public static function copyDir($oldDir, $aimDir, $overWrite = false)
    {
        $aimDir = str_replace('', '/', $aimDir);
        $aimDir = substr($aimDir, -1) == '/' ? $aimDir : $aimDir . '/';
        $oldDir = str_replace('', '/', $oldDir);
        $oldDir = substr($oldDir, -1) == '/' ? $oldDir : $oldDir . '/';
        if (!is_dir($oldDir)) {
            return false;
        }
        if (!file_exists($aimDir)) {
            file::createDir($aimDir);
        }
        $dirHandle = opendir($oldDir);
        while (false !== ($file = readdir($dirHandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($oldDir . $file)) {
                file::copyFile($oldDir . $file, $aimDir . $file, $overWrite);
            } else {
                file::copyDir($oldDir . $file, $aimDir . $file, $overWrite);
            }
        }
        return closedir($dirHandle);
    }

    /**
     * 复制文件
     *
     * @param string $fileUrl
     * @param string $aimUrl
     * @param boolean $overWrite 该参数控制是否覆盖原文件
     * @return boolean
     */
    public static function copyFile($fileUrl, $aimUrl, $overWrite = false)
    {
        if (!file_exists($fileUrl)) {
            return false;
        }
        if (file_exists($aimUrl) && $overWrite == false) {
            return false;
        } elseif (file_exists($aimUrl) && $overWrite == true) {
            file::unlinkFile($aimUrl);
        }
        $aimDir = dirname($aimUrl);
        file::createDir($aimDir);
        copy($fileUrl, $aimUrl);
        return true;
    }

    /**
     * Add fun by sam@imccc.net
     */
    /**
     * 目录列表
     * @param string $dir 要读取的目录
     */
    public static function listDir($dir)
    {
        $files = array();
        if (@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
            while (($file = readdir($handle)) !== false) {
                if ($file != ".." && $file != ".") { //排除根目录；
                    if (is_dir($dir . "/" . $file)) { //如果是子文件夹，就进行递归
                        $files[$file] = file::listDir($dir . "/" . $file);
                    } else { //不然就将文件的名字存入数组；
                        $files[] = $file;
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }

    /**
     * 读取文件操作
     * @param string $file
     * @return boolean
     */
    public function readFile($file)
    {
        return @file_get_contents($file);
    }

    /**
     * 文件重命名
     * @param string $oldname
     * @param string $newname
     */
    public function rename($oldname, $newname)
    {
        if (($newname != $oldname) && is_writable($oldname)) {
            return rename($oldname, $newname);
        }
    }

    /**
     * 指定文件编码转换
     * @param string $path 文件路径
     * @param string $input_code 原始编码
     * @param string $out_code 输出编码
     * @return boolean
     */
    public function changeFileCode($path, $input_code, $out_code)
    {
        if (is_file($path)) //检查文件是否存在,如果存在就执行转码,返回真
        {
            $content = file_get_contents($path);
            $content = string::changCode($content, $input_code, $out_code);
            $fp = fopen($path, 'w');
            return fputs($fp, $content) ? true : false;
            fclose($fp);
        }
    }

    /**
     * 指定目录下指定条件文件编码转换
     * @param string $dirname 目录路径
     * @param string $input_code 原始编码
     * @param string $out_code 输出编码
     * @param boolean $is_all 是否转换所有子目录下文件编码
     * @param string $exts 文件类型
     * @return boolean
     */
    public function changeDirFilesCode($dirname, $input_code, $out_code, $is_all = true, $exts = '')
    {
        if (is_dir($dirname)) {
            $fh = opendir($dirname);
            while (($file = readdir($fh)) !== false) {
                if (strcmp($file, '.') == 0 || strcmp($file, '..') == 0) {
                    continue;
                }
                $filepath = $dirname . '/' . $file;

                if (is_dir($filepath) && $is_all == true) {
                    $files = self::changeDirFilesCode($filepath, $input_code, $out_code, $is_all, $exts);
                } else {
                    if (self::getExt($filepath) == $exts && is_file($filepath)) {
                        $boole = self::changeFileCode($filepath, $input_code, $out_code, $is_all, $exts);
                        if (!$boole) {
                            continue;
                        }
                    }
                }
            }
            closedir($fh);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取文件后缀名
     * @param string $file_name 文件路径
     * @return string
     */
    public function getExt($file)
    {
        $file = str_replace('//', '/', str_replace('\\', '/', $path));
        return pathinfo($file, PATHINFO_EXTENSION);
    }
    /**
     * 返回指定文件和目录的信息
     * @param string $file
     * @return ArrayObject
     */
    public static function listInfo($file)
    {
        $dir = array();
        $dir['filename'] = basename($file); //返回路径中的文件名部分。
        $dir['pathname'] = realpath($file); //返回绝对路径名。
        $dir['owner'] = fileowner($file); //文件的 user ID （所有者）。
        $dir['perms'] = fileperms($file); //返回文件的 inode 编号。
        $dir['inode'] = fileinode($file); //返回文件的 inode 编号。
        $dir['group'] = filegroup($file); //返回文件的组 ID。
        $dir['path'] = dirname($file); //返回路径中的目录名称部分。
        $dir['atime'] = fileatime($file); //返回文件的上次访问时间。
        $dir['ctime'] = filectime($file); //返回文件的上次改变时间。
        $dir['perms'] = fileperms($file); //返回文件的权限。
        $dir['size'] = filesize($file); //返回文件大小。
        $dir['type'] = filetype($file); //返回文件类型。
        $dir['ext'] = is_file($file) ? pathinfo($file, PATHINFO_EXTENSION) : ''; //返回文件后缀名
        $dir['mtime'] = filemtime($file); //返回文件的上次修改时间。
        $dir['isDir'] = is_dir($file); //判断指定的文件名是否是一个目录。
        $dir['isFile'] = is_file($file); //判断指定文件是否为常规的文件。
        $dir['isLink'] = is_link($file); //判断指定的文件是否是连接。
        $dir['isReadable'] = is_readable($file); //判断文件是否可读。
        $dir['isWritable'] = is_writable($file); //判断文件是否可写。
        $dir['isUpload'] = is_uploaded_file($file); //判断文件是否是通过 HTTP POST 上传的。
        return $dir;
    }

}
