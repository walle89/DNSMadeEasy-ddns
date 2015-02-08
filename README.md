# DNS Made Easy DDNS
Simple DNS Made Easy Dynamic DNS client written in PHP.

**Features**

* With the cache enabled, it's only updates the DNS records when the IP have changed.
* Cache expire makes sure the DNS recod is in sync.
* Update one or serveral DNS records in one IP change update.
* Can be triggered both via CLI or in a http request

## System requirements

* PHP 5.2+
* Either cURL **or** allow_url_fopen enabled 

## Installation

Clone or download zip
```bash
git clone git@github.com:walle89/DNSMadeEasy-ddns.git
```

Copy config.sample.php to config.php and change the settings.

Test if it's wokring
```bash
php index.php
```

Add a new cronjob for automatic checks
```
* * * * * /usr/bin/php /path/to/ddns/index.php > /dev/null 2>&1
```
**Or** via HTTP
```
* * * * * /usr/bin/wget --no-check-certificate -q -O /dev/null "http://localhost/ddns/" >/dev/null 2>&1
```

## Updates

Either do a git pull or download a new zip and overwrite with the new files.

## Feedback, issues, bugs, etc.

Create a [Github Issue](https://github.com/walle89/DNSMadeEasy-Dynamic-DNS/issues).

## Licens (MIT)
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
