<?php


namespace Solarium\QueryType\ManagedResources\Query;

use InvalidArgumentException;
use Solarium\Core\Client\Client;
use Solarium\Core\Query\AbstractQuery as BaseQuery;
use Solarium\QueryType\ManagedResources\Query\Synonyms\Command\AbstractCommand;
use Solarium\QueryType\ManagedResources\RequestBuilder\Synonyms as RequestBuilder;
use Solarium\QueryType\ManagedResources\ResponseParser\Synonyms as ResponseParser;

class Synonyms extends BaseQuery {

    /**
     * Synonyms command add.
     */
    const COMMAND_ADD = 'add';

    /**
     * Synonyms command delete.
     */
    const COMMAND_DELETE = 'delete';

    /**
     * Synonyms command delete.
     */
    const COMMAND_EXISTS = 'exists';

    /**
     * Name of the synonyms resource.
     *
     * @var string
     */
    protected $name = "";

    /**
     * ResourceId looked up using the managed resources component.
     * @var string
     */
    protected $resourceId;

    /**
     * Whether or not to ignore the case.
     * @var boolean
     */
    protected $ignoreCase;

    /**
     * Controls how the synonyms will be parsed.
     * The short names solr (for SolrSynonymParser) and wordnet (for
     * WordnetSynonymParser ) are supported, or you may alternatively supply
     * the name of your own SynonymMap.Builder subclass.
     * @var string
     */
    protected $format;

    /**
     * Cmmand.
     *
     * @var AbstractCommand
     */
    protected $command;

    /**
     * Synonyms command types.
     *
     * @var array
     */
    protected $commandTypes = [
        self::COMMAND_ADD => 'Solarium\QueryType\ManagedResources\Query\Synonyms\Command\Add',
        self::COMMAND_DELETE => 'Solarium\QueryType\ManagedResources\Query\Synonyms\Command\Delete',
        self::COMMAND_EXISTS => 'Solarium\QueryType\ManagedResources\Query\Synonyms\Command\Exists',
    ];

    /**
     * Default options.
     *
     * @var array
     */
    protected $options = [
        'handler' => 'schema/analysis/synonyms/',
        'resultclass' => 'Solarium\QueryType\ManagedResources\Result\Synonyms',
        'omitheader' => true,
    ];

    /**
     * Get query type.
     *
     * @return string
     */
    public function getType() {
        return Client::QUERY_MANAGED_SYNONYMS;
    }

    /**
     * Get the request builder class for this query.
     *
     * @return RequestBuilder
     */
    public function getRequestBuilder() {
        return new RequestBuilder();
    }

    /**
     * Get the response parser class for this query.
     *
     * @return ResponseParser
     */
    public function getResponseParser() {
        return new ResponseParser();
    }

    /**
     * Get the name of the synonym resource.
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Set the name of the synonym resource.
     * @param string $name
     */
    public function setName(string $name) {
        $this->name = $name;
    }

    /**
     * Create a command instance.
     *
     * @param string $type
     * @param mixed  $options
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractCommand
     */
    public function createCommand($type, $options = null)
    {
        $type = strtolower($type);

        if (!isset($this->commandTypes[$type])) {
            throw new InvalidArgumentException('Synonyms commandtype unknown: '.$type);
        }

        $class = $this->commandTypes[$type];

        return new $class($options);
    }

    /**
     * Get command for this synonyms query.
     *
     * @return AbstractCommand
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Add a command to this synonyms query.
     *
     * @param AbstractCommand $command
     *
     * @return self Provides fluent interface
     */
    public function addCommand(AbstractCommand $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Remove command.
     *
     * @return self Provides fluent interface
     */
    public function removeCommand()
    {
        $this->command = null;

        return $this;
    }
}