<?php

namespace Tkotosz\CommandScheduler\Request\Factory;

use Tkotosz\CommandScheduler\Request\CreateCommandScheduleRequest;
use Magento\Framework\App\RequestInterface;

class CreateCommandScheduleRequestFactory
{
    public function createFromHttpRequest(RequestInterface $request)
    {
        $params = $request->getParams();

        if (empty($params['command_name'])) {
            throw new \InvalidArgumentException('missing required param: command_name');
        }

        return new CreateCommandScheduleRequest(
            $params['command_name'],
            $params['command_params'] ?? []
        );
    }
}
