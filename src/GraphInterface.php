<?php

interface GraphInterface 
{
    public function addEdge($startNode, $endNode);
    public function build();
}