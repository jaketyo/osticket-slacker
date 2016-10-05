# osticket-slacker
## Remote Slack-Logging plugin for osTicket

## Production State: 
Master: [![Build Status](https://travis-ci.org/jaketyo/osticket-slacker.svg?branch=master)](https://travis-ci.org/jaketyo/osticket-logger)  
Develop: [![Build Status](https://travis-ci.org/jaketyo/osticket-slacker.svg?branch=develop)](https://travis-ci.org/jaketyo/osticket-logger)  
#### NOT PRODUCTION READY! See 'Known Bugs'.

## osTicket Version
This plugin was last tested on v1.10-rc.3.

### Known Bugs (osTicket v1.10-rc.3)
`$ticket->getTopic()->getName()` returns nil.  
`$ticket->getLastMessage()` returns nil.  
`$ticket->getSubject()` returns nil.  
