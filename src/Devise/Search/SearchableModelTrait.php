<?php namespace Devise\Search;

use Illuminate\Database\Query\Expression;

/**
 * Class SearchableModelTrait can be applied to an eloquent model
 * to give it "searchablity". You have to override the getColumns method
 * and/or make a
 *  protected $searchable = array('column1' => 1, 'column2' => 2);
 *
 * where numbers 1 and 2 are the respective relevance of those columns
 *
 * @package Devise\Search
 */
trait SearchableModelTrait
{
    /**
     * @var int
     */
    protected $totalWords = 0;


    /**
     * Makes the search process work for a model
     *
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        return $this->createSearchQuery($query, $search);
    }

    /**
     * Makes the search query to search for text by
     * relevance inside the database using IF statements
     *
     * @param  Query $query
     * @param  text  $search
     * @return Query
     */
    protected function createSearchQuery($query, $search)
    {
        if (!$search) {
            return $query;
        }

        $relevance_count = 0;
        $words = explode(' ', $search);

        $selects = [];

        foreach ($this->getColumns() as $column => $relevance)
        {
            $relevance_count += $relevance;
            $queries = $this->getSearchQueriesForColumn($column, $relevance, $words);

            foreach ($queries as $select) {
                $selects[] = $select;
            }
        }

        $this->addSelectsToQuery($query, $selects);
        $this->addWheresToQuery($query, $words);
        $this->filterQueryWithRelevance($query, ($relevance_count / 4));

        $this->makeJoins($query);

        return $query;
    }

    /**
     * Overrides how the relevance is calculated
     *
     * @param string $column
     * @param integer $relevance
     * @param array $words
     * @return array
     */
    protected function getSearchQueriesForColumn($column, $relevance, $words)
    {
        $queries = [];

        // look for a direct match
        $wordsTogether = implode(' ', $words);
        $veryRelevant = $relevance * 10;
        $queries[] = "if({$column} LIKE '%{$wordsTogether}%', {$veryRelevant}, 0)";

        // look for fuzzy text searches
        $words = $this->filterCommonWords($words);
        $this->totalWords = count($words);

        foreach ($words as $word)
        {
            $queries[] = "if({$column} LIKE '%{$word}%', {$relevance}, 0)";
        }

        return $queries;
    }

    /**
     * Filter out words like a, the, but, and, her, his, etc <-- even that one
     *
     * @param  array $words
     * @return array
     */
    protected function filterCommonWords($words)
    {
        $newWords = array_filter($words, function($value)
        {
            return strlen($value) > 3;
        });

        return $newWords ?: $words;
    }

    /**
     * Adds where clauses to this query based on the relevance
     */
    protected function filterQueryWithRelevance(&$query, $relevance_count)
    {
        $total = 0;
        $totalColumns = 0;
        $this->totalWords = $this->totalWords > 0 ? $this->totalWords : 1;

        foreach ($this->getColumns() as $column => $relevance)
        {
            $totalColumns++;
            $total += $relevance * $this->totalWords;
        }

        $query->havingRaw('relevance >= ' . $total / ($this->totalWords + $totalColumns));
        $query->orderBy('relevance', 'desc');
    }

    /**
     * Returns the search columns
     *
     * @return array
     */
    protected function getColumns()
    {
        return $this->searchable['columns'];
    }

    /**
     * Returns the tables that has to join
     * @return array
     */
    protected function getJoins() {
        return $this->searchable['joins'];
    }

    /**
     * Adds the join sql to the query
     *
     * @param $query
     */
    protected function makeJoins(&$query)
    {
        foreach ($this->getJoins() as $table => $keys) {
            $query->join($table, $keys[0], '=', $keys[1]);
        }
    }

    /**
     * Puts all the select clauses to the main query
     * @param $query
     * @param $selects
     */
    protected function addSelectsToQuery(&$query, $selects)
    {
        $selects = new Expression(join(' + ', $selects) . ' as relevance');
        $query->select([$this->getTable() . '.*', $selects]);
    }

    /**
     * Puts all where clauses into builder
     * @param $query
     * @param $selects
     */
    protected function addWheresToQuery(&$query, $words)
    {
        $query->where(function($query) use ($words) {
            foreach ($this->getColumns() as $column => $relevance)
            {
                foreach ($words as $word)
                {
                    $query->orWhere($column, 'LIKE', '%' . $word . '%');
                }
            }
        });
    }
}