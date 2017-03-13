<?php

class DataTables {
    
    /* These are the DataTables POST params from Ajax Request */
    private $iDraw;
    private $iStart;
    private $iLength;
    private $sSearch;
    private $bRegexSearch;
    private $aOrder;
    private $aColumns;
        
    function __construct($oConnection, $aPost) {
        
        $this->setDraw();
        $this->setStart();
        $this->setLength();
        $this->setSearch();
        $this->setRegexSearch();
        $this->setOrder();
        $this->setColumns();
    }

    
    
    /* Getters and Setters */
    
    function getDraw() {
        return $this->iDraw;
    }

    function getStart() {
        return $this->iStart;
    }

    function getLength() {
        return $this->iLength;
    }

    function getSearch() {
        return $this->sSearch;
    }

    function getRegexSearch() {
        return $this->bRegexSearch;
    }

    function getOrder() {
        return $this->aOrder;
    }

    function getColumns() {
        return $this->aColumns;
    }

    function setDraw($iDraw) {
        $this->iDraw = $iDraw;
    }

    function setStart($iStart) {
        $this->iStart = $iStart;
    }

    function setLength($iLength) {
        $this->iLength = $iLength;
    }

    function setSearch($sSearch) {
        $this->sSearch = $sSearch;
    }

    function setRegexSearch($bRegexSearch) {
        $this->bRegexSearch = $bRegexSearch;
    }

    function setOrder($aOrder) {
        $this->aOrder = $aOrder;
    }

    function setColumns($aColumns) {
        $this->aColumns = $aColumns;
    }


}