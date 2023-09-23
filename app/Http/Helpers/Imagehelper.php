<?php

use Illuminate\Support\Facades\Storage;
use Image as thumbimage;
use Illuminate\Support\Facades\File;

if (!function_exists('getFile')) {
    function getFile($name, $type, $isBanner = false, $for = "image")
    {
        $expiryDate = now()->addDay(); //The link will be expire after 1 day
        $defaultImagePath = "";

        if ($isBanner) {
            // $defaultImagePath =  URL::to('/') . '/storage/app/public' . '/uploads/default_banner.jpg?d=' . time();
            $src = 'default_banner.jpg';
        } else {
            // $defaultImagePath =  URL::to('/') . '/storage/app/public' . '/uploads/default.jpg?d=' . time();
            $src = 'default.jpg';
        }

        if ($for == 'thumb') {
            if (!empty($name) && \Storage::disk('s3')->exists($type . '/' . 'thumb' . '/' . $name)) {
                // return URL::to('/') . '/storage/app/public' . '/uploads/' . $type . '/' . 'thumb' . '/' . $name . '?d=' . time();
                $src = $type . '/' . 'thumb' . '/' . $name;
            } else {
                $src;
            }
        } elseif ($for == 'unlink') {
            if (!empty($name) && \Storage::disk('s3')->exists($type . '/' . $name)) {
                $src =  $type . '/' . $name;
            } else {
                $src = 'file_not_found';
            }
        } else {
            if (!empty($name) && \Storage::disk('s3')->exists($type . '/' . $name)) {
                $src = $type . '/' . $name;
            } else {
                $src;
            }
        }
        // return \Storage::disk('s3')->temporaryUrl($src, $expiryDate);
        return \Storage::disk('s3')->temporaryUrl($src, $expiryDate);
    }
}

if (! function_exists('saveMultipleImage')) {
    function saveMultipleImage($files,$type="",$id="",$sub_id="") {
        foreach ($files as $file) {
            // $actualImagePath = 'uploads/'.$type;
            // $actualImagePath = $type . '/' . $type . '_' . $id;
            $actualImagePath = $type;
            $extension = $file->extension();
            $originalImageName = $type.'_'.$id.'_'.$sub_id.'.'.$extension;
            // $file->storeAs($actualImagePath,$originalImageName,'public');
            \Storage::disk("s3")->putFileAs($actualImagePath, $file, $originalImageName);
            $sub_id++;
        }

        return true;
    }
}

if (!function_exists('ListingImageUrl')) {
    function ListingImageUrl($type, $name, $for = "image", $isBanner = false)
    {
        $src = '';
        $expiryDate = now()->addDay(); //The link will be expire after 1 day
        $defaultImagePath = "";

        if ($isBanner) {
            $defaultImagePath = 'default_banner.jpg';
        } else {
            $defaultImagePath =  'default.jpg';
        }
        if ($for == 'thumb') {
            //added by : Pradyumn, Added on : 10-Oct-2022, Use: set path of s3 bucket
            if (!empty($name) && \Storage::disk('s3')->exists($type . '/' . 'thumb' . '/' . $name)) {
                $src = $type . '/' . 'thumb' . '/' . $name;
            } else {
                //default image path
                $src = $defaultImagePath;
            }
        } else {
            if (!empty($name) && \Storage::disk('s3')->exists($type . '/' . $name)) {
                $src = $type . '/' . $name;
            } else {
                //default image path
                $src = $defaultImagePath;
            }
        }
        // return url($src);
        return \Storage::disk('s3')->temporaryUrl($src, $expiryDate);
    }
}

if (!function_exists('file_exist_ret')) {
    function file_exist_ret($type, $id, $ib, $ext)
    {
        if (file_exists(\Storage::disk('s3')->exists($type . '/' . $type . '_' . $id . '_' . $ib . '.' . $ext))) {
            $ib = $ib + 1;
            return file_exist_ret($type, $id, $ib, $ext);
        } else {
            return $ib;
        }
    }
}

if (!function_exists('file_view_api')) {
    function file_view_api($type, $id, $returnThumb = 0)
    {
        $expiryDate = now()->addDay(); //The link will be expire after 1 day

        if($returnThumb == 1){
            $src_files = $type.'/thumb';
            $files = \Storage::disk('s3')->allFiles($src_files, $expiryDate);
        } else {
            $src_files = $type;
            $files = \Storage::disk('s3')->allFiles($src_files, $expiryDate);
        }
        $src = '';
        $src_array = array();

        if (isset($files[0]) && $files[0] != '') {
            $i=1;
            foreach($files as $file) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                $da = $type.'/'.'thumb/'.$type.'_thumb_'.$id.'_'.$i.'.'.$ext;

                if ($returnThumb == 1) {
                    if (in_array($type.'/'.'thumb/'.$type.'_thumb_'.$id.'_'.$i.'.'.$ext, $files)){
                        $src = \Storage::disk('s3')->temporaryUrl($type.'/'.'thumb/'.$type.'_thumb_'.$id.'_'.$i.'.'.$ext, $expiryDate);
                        array_push($src_array, $src);
                        $i++;
                    }
                }
                else{
                    if (in_array($type.'/'.$type.'_'.$id.'_'.$i.'.'.$ext, $files)){
                        $src = \Storage::disk('s3')->temporaryUrl($type.'/'.$type.'_'.$id.'_'.$i.'.'.$ext, $expiryDate);
                        array_push($src_array, $src);
                        $i++;
                    }
                }
            }
        }

        return $src_array;
    }
}

if (!function_exists('file_thumb_view')) {
    function file_thumb_view($type, $id, $num_of_imgs = 0)
    {
        $expiryDate = now()->addDay(); //The link will be expire after 1 day
        $src_files = $type.'/'.$type.'_'.$id.'/thumb';
        $files = \Storage::disk('s3')->allFiles($src_files, $expiryDate);
        $src = '';
        $src_array = array();

        if ($files[0] != '') {
            $i=1;
            foreach($files as $file) {
                $ext = pathinfo($file, PATHINFO_EXTENSION);

                if (in_array($type.'/'.$type.'_'.$id.'/'.'thumb/'.$type.'_thumb_'.$id.'_'.$i.'.'.$ext, $files)){
                    $src = \Storage::disk('s3')->temporaryUrl($type.'/'.$type.'_'.$id.'/'.'thumb/'.$type.'_thumb_'.$id.'_'.$i.'.'.$ext, $expiryDate);
                    array_push($src_array, $src);
                }
                $i++;
            }
        }

        return $src_array;
    }
}

if (!function_exists('saveSingleImage')) {
    function saveSingleImage($file, $type = "", $id = "")
    {
        $actualImagePath = $type;
        $extension = $file->extension();
        $originalImageName = $type . '_' . $id . '.' . $extension;
        \Storage::disk("s3")->putFileAs($actualImagePath, $file, $originalImageName);

        return $originalImageName;
    }
}

if (!function_exists('createThumbnail')) {
    function createThumbnail($file, $type = "", $id = "", $for = "image")
    {
        $avatar = $file;
        $extension = $file->getClientOriginalExtension();
        $filename =  $type . '_thumb_' . $id . '.' . $file->extension();
        $thumbnailFilePath =  $type . '/thumb';

        $width = config('global.DEFAULT_THUMB_IMAGE_WIDTH');
        $height = config('global.DEFAULT_THUMB_IMAGE_HEIGHT');

        if ($for == 'banner') {
            $width = config('global.BANNER_THUMB_IMAGE_WIDTH');
            $height = config('global.BANNER_THUMB_IMAGE_HEIGHT');
        }
        $normal = thumbimage::make($avatar)->resize($width, $height)->encode($extension);
        \Storage::disk('s3')->put($thumbnailFilePath . '/' . $filename, (string)$normal);

        return $filename;
    }
}

if (!function_exists('createThumbnailMultiple')) {
    function createThumbnailMultiple($file, $type = "", $id = "", $for = "image",$i = "")
    {
        $avatar = $file;
        $extension = $file->getClientOriginalExtension();
        $filename =  $type . '_thumb_' . $id . '_' . $i  . '.' . $file->extension();
        $thumbnailFilePath =  $type.'/'.$type . '_' . $id . '/thumb';
        $thumbnailFilePath =  $type . '/' . '/thumb';

        $width = config('global.DEFAULT_THUMB_IMAGE_WIDTH');
        $height = config('global.DEFAULT_THUMB_IMAGE_HEIGHT');

        if ($for == 'banner') {
            $width = config('global.BANNER_THUMB_IMAGE_WIDTH');
            $height = config('global.BANNER_THUMB_IMAGE_HEIGHT');
        }
        $normal = thumbimage::make($avatar)->resize($width, $height)->encode($extension);
        \Storage::disk('s3')->put($thumbnailFilePath . '/' . $filename, (string)$normal);

        return $filename;
    }
}

if (!function_exists('file_view')) {
    function file_view($type, $id, $num_of_imgs = 0)
    {
        $expiryDate = now()->addDay(); //The link will be expire after 1 day
        $src_files = $type;
        $files = \Storage::disk('s3')->allFiles($src_files, $expiryDate);

        $src = '';
        $src_array = array();

        $image = $type.'/'.$type.'_'.$id.'_';

        $image_name_arr = array_filter($files, function($el) use ($image) {
            return (strpos($el, $image) !== false);
        });

        foreach ($image_name_arr as $key => $value) {
            $ext = pathinfo($value, PATHINFO_EXTENSION);
            $src = \Storage::disk('s3')->temporaryUrl($value, $expiryDate);
            array_push($src_array, $src);
        }

        return $src_array;
    }
}
if (!function_exists('file_view_thumb')) {
    function file_view_thumb($type, $id, $num_of_imgs)
    {
        $files = explode(',', implode(',', preg_grep('~^' . $type . '_thumb_' . $id . '_~', scandir(\Storage::disk('s3')->url($type . "/thumb")))));
        return $files;
        $src = '';
        if ($files[0] != '') {
            for ($i = 0; $i < count($files); $i++) {
                if ($src == '') {
                    $src = \Storage::disk('s3')->url($type . '/thumb' .'/' . $files[$i] ) . '||' . str_replace('products_', '', (explode('.', $files[$i]))[0]);
                } else {
                    $src = $src . ','.\Storage::disk('s3')->url($type . '/' . $files[$i] ) . '||' . str_replace('products_', '', (explode('.', $files[$i]))[0]);
                }
            }
        }
        return $src;
    }
}
if (!function_exists('file_copy')) {
    function file_copy($image, $id, $copy_id, $img_num)
    {
        $type = 'product';
        $extension=explode('.',$image);
        $img_name = $type.'_' .  $id . '_' . $img_num . '.' . $extension[1];
        print_r($img_name);
        die;

        $file_headers = @get_headers($image);
        if($file_headers && !str_contains($file_headers[0],'404')){
            File::copy($image,\Storage::disk('s3')->url('product/'.$img_name));
        }
        $thumb_image=file_view_thumb('product', $copy_id, 0)[0];
        $imageUrl = ListingImageUrl('product', $thumb_image,'thumb');
        if (!str_contains($imageUrl, 'banner')){
            $img_name_thumb = 'product_thumb_' .  $id . '_' . $img_num . '.' . $extension[1];
            $file_headers = @get_headers($imageUrl);
            if($file_headers && !str_contains($file_headers[0],'404')) {
                File::copy($imageUrl,\Storage::disk('s3')->url('product/thumb/'.$img_name_thumb));
            }
        }
    }
}
if (!function_exists('deleteImage')) {
    function deleteImage($id,$ib,$ext,$type = 'product')
    {
        
        $dir=\Storage::disk('s3')->url($type.'/');
        $file_path = $dir.$type.'_'.$id.'_'.$ib.'.'.$ext;
        $file_path = $type . '/' . $type.'_'.$id.'_'.$ib.'.'.$ext;

        if(\Storage::disk('s3')->exists($file_path)) \Storage::disk('s3')->delete($file_path);
        $file_thumb_path = $type . '/' .'thumb/'.$type.'_thumb_'.$id.'_'.$ib.'.'.$ext;
        if(\Storage::disk('s3')->exists($file_thumb_path)) \Storage::disk('s3')->delete($file_thumb_path);
    }
}
