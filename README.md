## Webex Teams notifier for Observium

This simple script can run on-box with Observium (somewhere in the web path Ex. ../html/...) and Observium can call the script as a Webhook contact for alerting. When Observium posts a JSON alert notification, the script will decode the payload and post the alert details to a designated Cisco Webex Teams Space.

You will need a valid Cisco Webex Teams AccessToken (Ex. Webex Teams Bot) and the "roomId" of the space you wish to post the alerts to. Whomever the AccessToken belongs to (a user or bot), that account must be a member in the space that you wish to post alerts to.

