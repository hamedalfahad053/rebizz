<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mybreadcrumb
{

    private $breadcrumbs = array();
    private $tags = "";

    function __construct()
    {
        $this->tags = array(
            "open"      => "<ul class='breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm'>",
            "close"     => "</ul>",
            "itemOpen"  => "<li class='breadcrumb-item'>",
            "itemClose" => "</li>"
        );
    }

    function add($title, $href)
    {
        if (!$title or !$href) return;
        $this->breadcrumbs[] = array('title' => $title, 'href' => $href);
    }

    function openTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['open'];
        } else {
            $this->tags['open'] = $tags;
        }
    }

    function closeTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['close'];
        } else {
            $this->tags['close'] = $tags;
        }
    }

    function itemOpenTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemOpen'];
        } else {
            $this->tags['itemOpen'] = $tags;
        }
    }

    function itemCloseTage($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemClose'];
        } else {
            $this->tags['itemClose'] = $tags;
        }
    }

    function render()
    {

        if (!empty($this->tags['open'])) {
            $output = $this->tags['open'];
        } else {
            $output = '<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">';
        }

        $count = count($this->breadcrumbs) - 1;
        foreach ($this->breadcrumbs as $index => $breadcrumb) {

            if ($index == $count) {
                $output .= '<li class="breadcrumb-item">';
                $output .= $breadcrumb['title'];
                $output .= '</li>';
            } else {
                $output .= ($this->tags['itemOpen']) ? $this->tags['itemOpen'] : '<li>';
                $output .= '<a class="text-muted" href="' . $breadcrumb['href'] . '">';
                $output .= $breadcrumb['title'];
                $output .= '</a>';
                $output .= '</li>';
            }

        }

        if (!empty($this->tags['open'])) {
            $output .= $this->tags['close'];
        } else {
            $output .= "</ul>";
        }


        return $output;
    }

}
