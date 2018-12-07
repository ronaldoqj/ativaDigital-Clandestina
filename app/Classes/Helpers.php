<?php
namespace Classes;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\FilesGaleria;
use Intervention\Image\ImageManagerStatic as Image;

class Helpers
{
    /*
     * Variavel para determinar qual pasta será salvo as imagens
     * Além de determinar a pasta para o método move do Symphone
     * também serve para determinar o drive de armazenamento do
     * Storage do Laravel, configurado em "config->filesystems.php"
     */
    private $loadImg = [];

    public function setDiretorioDrive ($diretorio) {
        $this->diretorioDrive = $diretorio;
    }

    public function loadImg($imgRequest, $thumb = 'thumb')
    {
        $file = $imgRequest;
        $this->loadImg['File'] = $file;
        $this->loadImg['MimeType'] = $file->getMimeType();
        $this->loadImg['OriginalName'] = $file->getClientOriginalName();
        $this->loadImg['OriginalExtension'] = $file->getClientOriginalExtension();
        $this->loadImg['RealPath'] = $file->getRealPath();
        $this->loadImg['Size'] = $file->getSize();
        // New Name
        $treatName = str_slug(str_before($file->getClientOriginalName(), '.'), '-');
        $newName = $treatName .
                      '_' . time() .
                      '.' . $file->getClientOriginalExtension();
        $this->loadImg['NewName'] = $newName;

        $treatNameThumb = str_slug(str_before($file->getClientOriginalName(), '.'), '-');
        $newNameThumb = $treatNameThumb .
                      '_' . time() .
                      '_'.$thumb.'.' . $file->getClientOriginalExtension();
        $this->loadImg['NewNameThumb'] = $newNameThumb;

        return $this->loadImg;
    }

    public function hex2rgb($hex)
    {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       //return implode(",", $rgb); // returns the rgb values separated by commas
       return $rgb; // returns an array with the rgb values
       // How to use
       // $rgb = hex2rgb("#cc0");
    }

    public function rgb2hex($rgb) // $rgb = array de 3 posições. Ex: [255,255,255]
    {
       $hex = "#";
       $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
       $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

       return $hex; // returns the hex value including the number sign (#)
       // How to use
       // $rgb = array( 255, 255, 255 );
       // $hex = rgb2hex($rgb);
    }

    // public function uploadImages ($files, $model)
    public function uploadImages ($params)
    {
        $returnIdsRegisters = [];

        $path = isset($params['path']) ? $params['path'] : 'images/_Files';
        $pathThumb = $path . '/_Thumbs';

        foreach ($params['files'] as $fileItem)
        {
            switch ( $params['model'] )
            {
                case 'FilesGaleria':
                    $register = new FilesGaleria();
                    break;
                case 'File':
                    $register = new File();
                    break;
            }

            // Set dos parametros de configuração
            $name = null;
            $namedefault = null;
            $description = null;
            $alternativetext = null;
            if ( isset($params['name']) ) { $name = $params['name']; }
            if ( isset($params['namedefault']) ) { $namedefault = $params['namedefault']; }
            if ( isset($params['description']) ) { $description = $params['description']; }
            if ( isset($params['alternative_text']) ) { $alternative_text = $params['alternative_text']; }

            $helpers = new Helpers();
            $file = $helpers->loadImg( $fileItem );
            $file['File']->move($path, $file['NewName']);
            $file['SizeThumb'] = null;

            if ( $params['thumb'] )
            {
                if ( isset($params['pathThumb']) ) {
                    $pathThumb = $params['pathThumb'];
                }

                $thumb = Image::make($path.'/'.$file['NewName'])->fit(200,150)->save($pathThumb.'/'.$file['NewNameThumb']);
                $file['SizeThumb'] = filesize($pathThumb.'/'.$file['NewNameThumb']);
            }

            // Save registers in bank
            if( file_exists($path.'/'.$file['NewName']) )
            {
                // Verificando se existe nome deftault
                $namedefault = $namedefault ? $namedefault : $file['NewName'];

                // Registering the images
                $register->path = $path;
                $register->name = $name ? $name : $namedefault;
                $register->namefile = $file['NewName'];
                $register->namefilefull = $path.'/'.$file['NewName'];
                $register->mimetype = $file['MimeType'];
                $register->extension = $file['OriginalExtension'];
                $register->size = $file['Size'];

                if ( $params['thumb'] )
                {
                    $register->paththumb =  $pathThumb;
                    $register->namefilethumb = $file['NewNameThumb'];
                    $register->namefilefullthumb = $pathThumb.'/'.$file['NewNameThumb'];
                    $register->mimetypethumb = $file['MimeType'];
                    $register->extensionthumb = $file['OriginalExtension'];
                    $register->sizethumb = $file['SizeThumb'];
                }

                $register->description = $description;
                $register->alternative_text = $alternativetext ? $alternativetext : $namedefault;
                $register->save();

                $returnIdsRegisters[] = $register->id;
                $register = null;
            }
        }

        return $returnIdsRegisters;
    }
}
