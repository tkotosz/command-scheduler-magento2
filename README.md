Command Scheduler module for Magento 2
=========================
[![License](https://poser.pugx.org/tkotosz/command-scheduler-magento2/license)](https://packagist.org/packages/tkotosz/command-scheduler-magento2)
[![Latest Stable Version](https://poser.pugx.org/tkotosz/command-scheduler-magento2/version)](https://packagist.org/packages/tkotosz/command-scheduler-magento2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tkotosz/command-scheduler-magento2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tkotosz/command-scheduler-magento2/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/tkotosz/command-scheduler-magento2/badges/build.png?b=master)](https://scrutinizer-ci.com/g/tkotosz/command-scheduler-magento2/build-status/master)

This module allows you to schedule bin/magento commands in the Magento admin. This makes it possible to run bin/magento command with only Magento admin access.

Usage:

1. Configure the allowed commands:
List of allowed commands can be configured in the di like this:
```
<type name="Tkotosz\CommandScheduler\Model\AllowedCommandsContainer">
    <arguments>
        <argument name="allowedCommands" xsi:type="array">
            <item name="Cache Clean" xsi:type="string">cache:clean</item>
        </argument>
    </arguments>
</type>
```

2. Schedule any allowed command on the System > Tools > Schedule Commands admin page

3. Wait for the schedule processor to run: By default a cron runs every 5 minute to process the next pending schedule. (alternatively you can use the bin/magento command-scheduler:process-next-schedule command to trigger the schedule processing)

4. Check the result of the command execution on the System > Tools > Schedule Commands admin page by clicking on the "view result" link