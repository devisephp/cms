<?php namespace Devise\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class InstallerCommand extends Command {

	public function configure()
	{
		$this->setName('install')
			->setDescription('Hello fine sir')
			->addArgument('name', InputArgument::OPTIONAL, 'Your Name');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');
		$output->writeln('Hello ' . $name);

	}


}