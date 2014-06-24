# Stack Exchange Craft Plugin

A quick little plugin for making your precious [Craft CMS Stack Exchange](http://craftcms.stackexchange.com/) profile information available in Craft templates.

### Example

Use `craft.stackExchange.getProfile()` with your Stack Exchange account ID (`http://craftcms.stackexchange.com/users/**YOUR ID**`) to get a single result:

```
{% set profile = craft.stackExchange.getProfile(22) %}

{{ profile.accountId }} {# 482701 #}
{{ profile.userId }} {# 22 #}
{{ profile.userType }} {# "registered" #}
{{ profile.displayName }} {# "Matt Stein" #}
{{ profile.creationDate }} {# 1402531180 #}
{{ profile.lastModifiedDate }} {# 1403051477 #}
{{ profile.lastAccessDate }} {# 1403550544 #}
{{ profile.reputation }} {# 723 #}
{{ profile.reputationChangeDay }} {# 7 #}
{{ profile.reputationChangeWeek }} {# 12 #}
{{ profile.reputationChangeMonth }} {# 722 #}
{{ profile.reputationChangeQuarter }} {# 722 #}
{{ profile.reputationChangeYear }} {# 722 #}
{{ profile.location }} {# "Seattle" #}
{{ profile.websiteUrl }} {# "http://workingconcept.com/" #}
{{ profile.link }} {# "http://craftcms.stackexchange.com/users/22/matt-stein" #}
{{ profile.profileImage }} {# "http://i.stack.imgur.com/zwqV6.jpg?s=128&g=1" #}
{{ profile.age }} {# 30 #}
{{ profile.badgeCounts.bronze }} {# 18 #}
{{ profile.badgeCounts.silver }} {# 2 #}
{{ profile.badgeCounts.gold }} {# 0 #}
{{ profile.acceptRate }} {# 100 #}
{{ profile.isEmployee }} {# false #}
```

Alternatively, you can use `craft.stackExchange.getProfiles()` to get one or several results.

```
{% set profile = craft.stackExchange.getProfiles(22) %}
{# identical to above #}

{% set profiles = craft.stackExchange.getProfiles([22, 115]) %}
{# loop through profiles for each result object #}
```


### Installation

Like other plugins, drop the `stackexchange` folder into your `craft/plugins` directory, visit Settings → Plugins in the control panel, and choose "Install." Then you can start using `craft.stackExchange` in your templates.
