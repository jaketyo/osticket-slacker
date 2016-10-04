# osticket-slacker
## Remote Slack-Logging plugin for osTicket

# NOT PRODUCTION READY

## osTicket Version
This plugin was last tested on v1.10-rc.3.

### Known Bugs (v1.10-rc.3)
`$ticket->getTopic()->getName()` returns nil.
`$ticket->getLastMessage()` returns nil.
`$ticket->getSubject()` returns nil.