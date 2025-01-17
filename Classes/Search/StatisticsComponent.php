<?php
namespace ApacheSolrForTypo3\Solr\Search;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2015 Ingo Renner <ingo@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use ApacheSolrForTypo3\Solr\Domain\Search\SearchRequest;
use ApacheSolrForTypo3\Solr\Domain\Search\SearchRequestAware;
use ApacheSolrForTypo3\Solr\Domain\Search\Statistics\StatisticsWriterProcessor;
use ApacheSolrForTypo3\Solr\Query\Modifier\Statistics;

/**
 * Statistics search component
 *
 * @author Ingo Renner <ingo@typo3.org>
 */
class StatisticsComponent extends AbstractComponent implements SearchRequestAware
{

    /**
     * @var SearchRequest
     */
    protected $seachRequest;

    /**
     * Provides a component that is aware of the current SearchRequest
     *
     * @param SearchRequest $searchRequest
     */
    public function setSearchRequest(SearchRequest $searchRequest)
    {
        $this->seachRequest = $searchRequest;
    }

    /**
     * Initializes the search component.
     *
     */
    public function initializeSearchComponent()
    {
        $solrConfiguration = $this->seachRequest->getContextTypoScriptConfiguration();

        if ($solrConfiguration->getStatistics()) {
            if (empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['solr']['afterSearch']['statistics'])) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['solr']['afterSearch']['statistics'] = StatisticsWriterProcessor::class;
            }
            // Only if addDebugData is enabled add Query modifier
            if ($solrConfiguration->getStatisticsAddDebugData()) {
                $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['solr']['modifySearchQuery']['statistics'] = Statistics::class;
            }
        }
    }

}
