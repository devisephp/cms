<?php


try
{
  App::make('Devise\Pages\RoutesGenerator')->loadRoutes();
} catch (PDOException $e)
{

}