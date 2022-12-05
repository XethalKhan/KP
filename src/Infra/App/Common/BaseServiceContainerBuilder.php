<?php

namespace KP\SOLID\Infra\App;

use KP\SOLID\UseCase\IConfiguration;
use KP\SOLID\UseCase\ILogger;

abstract class BaseServiceContainerBuilder {
    protected abstract function buildConfiguration();
    protected abstract function buildLogger(IConfiguration $configuration);
    protected abstract function buildRepositoryFactory(IConfiguration $configuration, ILogger $logger);
    protected abstract function buildMailer(IConfiguration $configuration, ILogger $logger);
    protected abstract function buildSession(IConfiguration $configuration, ILogger $logger);
    protected abstract function buildMailValidator(IConfiguration $configuration, ILogger $logger);

    public abstract function build() : BaseServiceContainer;
}