<?php
namespace GameOfLife\Environment;

class WorldFactory
{
    /**
     * @var NeighboursFactory
     */
    private $neighboursFactory;
    
    /**
     * @param NeighboursFactory $neighboursFactory
     */
    public function __construct(NeighboursFactory $neighboursFactory)
    {
        $this->neighboursFactory = $neighboursFactory;
    }

    public function create(WorldState $worldState)
    {
        return new World($worldState, $this->neighboursFactory);
    }

}
