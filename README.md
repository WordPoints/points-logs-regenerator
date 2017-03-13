Points Logs Regenerator [![Build Status](https://travis-ci.org/WordPoints/points-logs-regenerator.svg?branch=develop)](https://travis-ci.org/WordPoints/points-logs-regenerator) [![HackerOne Bug Bounty Program](https://img.shields.io/badge/security-HackerOne-blue.svg)](https://hackerone.com/wordpoints)
=======================

WordPoints module for regenerating the points logs.

You can find its [homepage on WordPoints.org](https://wordpoints.org/modules/points-logs-regenerator/).

WordPoints stores the text of the points logs statically. This has several benefits,
including reduction in the performance overhead of displaying the logs and making it
easier to display integrated logs on multisite. However, there are times when the
logs may need to be regenerated. Usually WordPoints will automatically regenerate
a particular log entry when it thinks this is needed. But sometimes you may want to
trigger the regeneration of the points logs manually, for example, if you have just
installed a translation.

This module adds a button to the _WordPoints » Points Logs_ administration screen,
which will cause the points logs to be regenerated when clicked. Note that all of the
logs for a site will be regenerated at once, not just those of one points type.

Please note that if you have a lot of points logs, regenerating them could take a lot
of time and server resources, and the process might not complete in some
circumstances. In the future, the feature may be added to regenerate the logs in
batches. Until then, it is suggested that you use caution before attempting to
regenerate more than a few thousand logs at once.

Be aware that this module has not yet been tested on multisite, though it should
work. On multisite, the logs of each site on the network would be regenerated
separately.
