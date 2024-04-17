<?php

require_once __DIR__ . '/GraphInterface.php';
									
$INT_MAX = 0x7FFFFFFF;

function MinimumDistance($distance, $shortestPathTreeSet, $verticesCount)
{
	global $INT_MAX;
	$min = $INT_MAX;
	$minIndex = 0;

	for ($v = 0; $v < $verticesCount; ++$v)
	{
		if ($shortestPathTreeSet[$v] == false && $distance[$v] <= $min)
		{
			$min = $distance[$v];
			$minIndex = $v;
		}
	}

	return $minIndex;
}

function PrintResult($distance, $verticesCount)
{
	echo "<pre>" . "Vertex    Distance from source" . "</pre>";

	for ($i = 0; $i < $verticesCount; ++$i)
		echo "<pre>" . $i . "\t  " . $distance[$i] . "</pre>";
}

function Dijkstra($graph, $source, $verticesCount)
{
	global $INT_MAX;
	$distance = array();
	$shortestPathTreeSet = array();

	for ($i = 0; $i < $verticesCount; ++$i)
	{
		$distance[$i] = $INT_MAX;
		$shortestPathTreeSet[$i] = false;
	}

	$distance[$source] = 0;

	for ($count = 0; $count < $verticesCount - 1; ++$count)
	{
		$u = MinimumDistance($distance, $shortestPathTreeSet, $verticesCount);
		$shortestPathTreeSet[$u] = true;

		for ($v = 0; $v < $verticesCount; ++$v)
			if (!$shortestPathTreeSet[$v] && $graph[$u][$v] && $distance[$u] != $INT_MAX && $distance[$u] + $graph[$u][$v] < $distance[$v])
				$distance[$v] = $distance[$u] + $graph[$u][$v];
	}

	PrintResult($distance, $verticesCount);
}

class Graph implements GraphInterface 
{
    private $graph = [];
    private $checked = [];

    function __construct(array $edges = [])
    {
        $this->checked = [];

        foreach ($edges as $edge) {
            $this->addEdge($edge[0], $edge[1]);
        }
    }

    public function addEdge($startNode, $endNode): void
    {
        if (empty($this->graph[$startNode])) {
            $this->graph[$startNode] = [];
        }

        $this->graph[$startNode][] = $endNode;
    }

    function findFastestNode( $times )
    {
        $minTime = INF;
        $fastestNode = null;
        foreach( $times as $n => $time )
        {       
            if( $time < $minTime AND !in_array( $n, $this->checked ) )
            {
                $minTime = $time;
                $fastestNode = $n;
            }
        }
        return $fastestNode;
    }

    public function build( )
    {
        $graph = array(
            array(0, 4, 0, 0, 0, 0, 0, 8, 0),
            array(4, 0, 8, 0, 0, 0, 0, 11, 0),
            array(0, 8, 0, 7, 0, 4, 0, 0, 2),
            array(0, 0, 7, 0, 9, 14, 0, 0, 0),
            array(0, 0, 0, 9, 0, 10, 0, 0, 0),
            array(0, 0, 4, 0, 10, 0, 2, 0, 0),
            array(0, 0, 0, 14, 0, 2, 0, 1, 6),
            array(8, 11, 0, 0, 0, 0, 1, 0, 7),
            array(0, 0, 2, 0, 0, 0, 6, 7, 0)
        );
        
        // Dijkstra($this->graph, 0, 9);
 
        return $this->graph; 
    }
}