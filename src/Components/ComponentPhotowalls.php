<?php

namespace Partymeister\Frontend\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Motor\CMS\Models\PageVersionComponent;

class ComponentPhotowalls {

    protected $pageVersionComponent;
    protected $photos;
    protected $pages;
    protected $currentPage;
    protected $currentBlock;


    /**
     * ComponentPhotowalls constructor.
     * @param PageVersionComponent $pageVersionComponent
     */
    public function __construct(PageVersionComponent $pageVersionComponent)
    {
        $this->pageVersionComponent = $pageVersionComponent;
    }


    /**
     * @param Request $request
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->photos = $this->scanDir(base_path('public/photowall/cache'));

        if (!$this->photos) {
            return false;
        }

        $limit = 90;
        $page = Arr::get($_GET, 'page', 1)-1;

        $this->photos = array_chunk($this->photos, $limit);

        if (isset($this->photos[$page]))
        {
            $this->currentBlock = $this->photos[$page];
        }
        else
        {
            $this->currentBlock = $this->photos[0];
        }

        //$dates = array();
        //foreach ($current_block as $key => $photo)
        //{
        //    $found = FALSE;
        //    foreach ($metadata as $wurst)
        //    {
        //        if ($found) continue;
        //
        //        if (strpos($wurst, str_replace('big_', '', $photo)) !== FALSE)
        //        {
        //            $found = TRUE;
        //            $blah = explode('\t', $wurst);
        //            $dates[$key] = trim(trim($blah[0]));
        //        }
        //    }
        //}

        $this->pages = count($this->photos);
        $this->currentPage = $page+1;
        $this->photos = $this->currentBlock;


        return $this->render();
    }


    /**
     * @param $dir
     * @return array|bool
     */
    protected function scanDir($dir)
    {
        $ignored = array(
            '.',
            '..',
            '.svn',
            '.htaccess',
            'Thumbs.db'
        );

        $files = array();

        if (!is_dir($dir)) {
            return false;
        }

        foreach (scandir($dir) as $file)
        {
            if (in_array($file, $ignored) || strpos(strtolower($file), '.jpg') === FALSE)
            {
                continue;
            }
            $files[$file] = $file;
        }

        arsort($files);
        $files = array_keys($files);

        return ($files) ? $files : FALSE;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view(config('motor-cms-page-components.components.'.$this->pageVersionComponent->component_name.'.view'), ['pages' => $this->pages, 'currentPage' => $this->currentPage, 'currentBlock' => $this->currentBlock, 'photos' => $this->photos]);
    }

}
