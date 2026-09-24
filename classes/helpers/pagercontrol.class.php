<?php

class PagerControl {

    private $_pagerCssClass = 'pagination';
    private $_buttonCssClass = 'number';
    private $_currentButtonCssClass = 'current';
    private $_useJavaScript = false;
    private $_functionName = null;
    private $_currentPage = 1;
    private $_pages = null;
    private $_visiblePages = 10;

    public function __construct($p_pages) {
        $this->_pages = $p_pages;
    }

    public function set_pagerCssClass($p_css) {
        $this->_pagerCssClass = $p_css;
    }

    public function set_buttonCssClass($p_css) {
        $this->_buttonCssClass = $p_css;
    }

    public function set_currentButtonCssClass($p_css) {
        $this->_currentButtonCssClass = $p_css;
    }

    /**
     * Define si los enlaces del paginador van a ejecutar una funcion javascript o se utiliza una url en el href.
     * @param boolean $p_useJavascript
     */
    public function useJavaScript($p_useJavascript = false) {
        if (is_bool($p_useJavascript)) {
            $this->_useJavaScript = $p_useJavascript;
        } else {
            $this->_useJavaScript = false;
        }
    }

    public function set_jsFunctionName($p_function_name) {
        $this->_functionName = $p_function_name;
    }

    public function set_currentPage($p_page_number = 1) {
        $this->_currentPage = $p_page_number;
    }

    public function get_control() {

        $html = "<div class=\"{$this->_pagerCssClass}\">";

        if ($this->_visiblePages > 0) {

            if ($this->_currentPage > 1) {
                $html.= "<a class=\"{$this->_buttonCssClass}\" href=\"javascript:;\" onclick=\"{$this->_functionName}('" . ($this->_currentPage - 1) . "')\">«</a>";
            }

            if ($this->_currentPage > ceil($this->_visiblePages / 2)) {

                $min_visible_page = (($this->_currentPage - ceil($this->_visiblePages / 2)) > 1) ? ($this->_currentPage - ceil($this->_visiblePages / 2)) : 1;
                $max_visible_page = $this->_currentPage + ceil($this->_visiblePages / 2);
                if ($max_visible_page >= $this->_pages) {
                    $max_visible_page = $this->_pages;
                    $min_visible_page = ($this->_pages - ($this->_visiblePages) > 1) ? $this->_pages - ($this->_visiblePages) : 1;
                }
            } else {
                $min_visible_page = 1;
                $max_visible_page = ($this->_pages >= $this->_visiblePages) ? $this->_visiblePages : $this->_pages;
            }
            
            for ($i = $min_visible_page; $i <= $max_visible_page; $i++) {
                if ($this->_currentPage == $i) {
                    $html.= "<a href=\"#\" class=\"{$this->_buttonCssClass} {$this->_currentButtonCssClass}\">{$i}</a>";
                } else {
                    $html.= "<a class=\"{$this->_buttonCssClass}\" href=\"javascript:;\" onclick=\"{$this->_functionName}('{$i}')\">{$i}</a>";
                }
            }

            if ($this->_currentPage < $this->_pages) {
                $html.= "<a class=\"{$this->_buttonCssClass}\" href=\"javascript:;\" onclick=\"{$this->_functionName}('" . ($this->_currentPage + 1) . "')\">»</a>";
            }
        }
        $html.= '</div>';
        return $html;
    }

}

?>