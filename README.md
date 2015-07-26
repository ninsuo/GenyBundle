# GenyBundle

Goal of this project is to provide:
- a user interface to create forms
- a user interface to display and validate those forms

---

There are tons of ideas where admin may need to draw a form, set a template (not necessarily a view) and then final user can give the context by filling the form.
This way, user's context is mixed to admin's template and, according to a website's goal, do some stuff without any programming needs.

Some websites examples:
- a highly-dynamic back end: admin define sql query/linux command templates and the context form: and users can run those query/commands after filling that form.
- a code generator: user define templates and forms to complete the context, and then just need to fill it as much times as he want.
- ...

To make this possible, I need to:
- define what's a form inside a configuration file
- create tools to take that file and display/validate a form
- create tools to display a friendly form to generate that file (thus, forms)

Why would I use a configuration file between the form creator and the form renderer?
- if a form can be stored inside a json file, it can be easily stored on a database/shared through apis...
- as this will be generic, it will be possible to make those forms compatible with mobile devices
