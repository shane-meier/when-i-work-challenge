# when-i-work-challenge
Repository for When I Work challenge
```
 How to Run:
 - Need to have PHP and NPM installed
 - Need to get your javascript up and running (npm run serve)
 - Run a PHP server and hit your local host "http://localhost:8080/?"
 - I used VScode and a php extention (PHP Server) to get the php server up and running quickly
```

## What would I change if this had proper fleshing out
```
First off fun challenge!
Been a while since I worked with time caluclations so it was a fun challenge
Things I would change
Sometime was lost due to difficulty setting up local enviorment for the stack I chose (Docker and other VM programmatic setups would save time in the future)
 - The php webserver was hastily thrown together and does not properly check for secure connections
 - It would be nice to break the injestion of the JSON file from the frontend into a proper API. 
    Meaning it can accept both files and properly formatted data that we expect and need to parse through.
 - proper storage for the files we recieve for later reference
 - Sanitize the data we recieve to make sure we are protecting our platform from unwanted data and users
 - Move a few of the calucations into their own services that can be used from multiple files and places in the platform and not restricted to the one file
 - Frontend is not pretty and up to my usual standards. Went for a quick and dirty fix for accomplishing the challenge. 
    With more time would like to flesh out a proper user friendly design
 - Left in some console.logs I usually wouldn't just for easier tracking of whats happening for this challenge
 
 NEED TO FIX INVALID SHIFT
 - Had some difficulty throwing together a proper way to determine that shifts for an employee overlapped. Would be awesome to hear from the other seniors at When I Work
    About the best option on how to resolve the issue

The cardinal sin of not having proper test implemented. Would be happy to discuss proper testing technique
```
