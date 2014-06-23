# Stack Exchange Craft Plugin

A quick little plugin for making your precious [Craft CMS Stack Exchange](http://craftcms.stackexchange.com/) profile information available in Craft templates.

### Example

Use `craft.stackExchange.getProfile()` with your Stack Exchange account ID. (`http://craftcms.stackexchange.com/users/**YOUR ID**`):

```
{% set se = craft.stackExchange.getProfile(22) %}

{{ se.reputation_change_day }} {# 7 #}
{{ se.badge_counts.bronze }} {# 18 #}
{{ se.badge_counts.silver }} {# 2 #}
{{ se.badge_counts.gold }} {# 0 #}
{{ se.badge_counts.location }} {# "Seattle" #}
{{ se.profile_image }} {# "http://i.stack.imgur.com/zwqV6.jpg?s=128&g=1" #}
{{ se.last_access_date }} {# 1403550544 #}
{{ se.accept_rate }} {# 100 #}
{{ se.link }} {# "http://craftcms.stackexchange.com/users/22/matt-stein" #}
{{ se.user_id }} {# 22 #}
{{ se.reputation_change_week }} {# 12 #}
{{ se.is_employee }} {# false #}
{{ se.website_url }} {# "http://workingconcept.com/" #}
{{ se.creation_date }} {# 1402531180 #}
{{ se.reputation_change_year }} {# 722 #}
{{ se.reputation }} {# 723 #}
{{ se.last_modified_date }} {# 1403051477 #}
{{ se.reputation_change_quarter }} {# 722 #}
{{ se.user_type }} {# "registered" #}
{{ se.account_id }} {# 482701 #}
{{ se.age }} {# 30 #}
{{ se.display_name }} {# "Matt Stein" #}
{{ se.reputation_change_month }} {# 722 #}
```

### Installation

Like other plugins, drop the `stackexchange` folder into your `craft/plugins` directory, visit Settings → Plugins in the control panel, and choose "Install." Then you can start using `craft.stackExchange` in your templates.
