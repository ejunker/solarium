<?php

namespace Solarium\QueryType\Server\Collections\Result;

class ClusterStatusResult extends AbstractResult
{
    /**
     * Returns the cluster state.
     *
     * @return ClusterState
     */
    public function getClusterState(): ClusterState
    {
        $this->parseResponse();
        if(isset($this->getData()['cluster']))
            return new ClusterState($this->getData()['cluster']);

        return new ClusterState([]);
    }
}
