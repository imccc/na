<?php
/**
 * 图象处理类
 * @author    imccc 
 * @since     2018-02-06 13:15:42 
 */
class image
{
    /**
     * 对图片进行base64编码转换
     * @param string $image_file
     * @return string
     */
    public static function base64EncodeImage($image_file)
    {
        $base64_image = '';
        if (is_file($image_file)) {
            $image_info   = getimagesize($image_file);
            $image_data   = fread(fopen($image_file, 'r'), filesize($image_file));
            $base64_image = 'data:' . $image_info['mime'] . ';base64,';
            $base64_image .= chunk_split(base64_encode($image_data));
        } else {
            return false;
        }
        return $base64_image;
    }

    /**
     * 对base64编码进行转换图片
     * @param string $image_file
     * @param string $url
     */
    public static function base64DecodeImage($image_file,$url)
    {
        $base64_string= explode(',', $base64_string);       //截取data:image/png;base64, 这个逗号后的字符
        $data= base64_decode($base64_string[1]);            //对截取后的字符使用base64_decode进行解码
        file_put_contents($url, $data);                     //写入文件并保存
    }
}