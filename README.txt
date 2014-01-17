The Edit quiz settings quiz report

This 'report' is actually a tool which lets users edit certain settings, currenty
the open and close dates, for a quiz, without needing to give them permission to
edit all the other quiz settings.

You can install it from the Moodle plugins database
http://moodle.org/plugins/view.php?plugin=quiz_editquizsettings

Alternatively, you can install it using git. In the top-level folder of your
Moodle install, type the command:
    git clone git://github.com/moodleou/moodle-quiz_editquizsettings.git mod/quiz/report/editquizsettings
    echo '/mod/quiz/report/editquizsettings/' >> .git/info/exclude

Then visit the admin screen to allow the install to complete.

Once the plugin is installed, you can access the functionality by going to
Reports -> Edit quiz settings in the Quiz adminstration block.
