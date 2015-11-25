<?php

return array(
    'acl' => array(
        'roles' => array(
            "Admin",
            "HR",
            "Manager",
            "Employee",
        ),
        "resources" => array(
            'Calendar\Controller\Index',
            'DefaultModule\Controller\Index',
            'DefaultModule\Controller\Error',
            'DefaultModule\Controller\Sign',
            'Myattendance\Controller\Index',
            'Myattendance\Controller\Attendance',
            'Myattendance\Controller\Vacation',
            'Notifications\Controller\Index',
            'Requests\Controller\Permission',
            'Requests\Controller\Vacation',
            'Requests\Controller\Workfromhome',
            "Users\Controller\Index",
            'Requests\Controller\Myrequests',
            'Settings\Controller\Index',
            'Settings\Controller\Vacation',
            'Settings\Controller\Position',
            'Settings\Controller\Holiday',
            'Settings\Controller\Departments',
            'Settings\Controller\Branches',
            'Settings\Controller\Attendance',
        ),
        "whitelist" => array(
            "All" => array(
                "roles" => array(
                    "Admin",
                    "HR",
                    "Manager",
                    "Employee",
                ),
                "resources" => array(
                    'Calendar\Controller\Index',
                    'DefaultModule\Controller\Index',
                    'DefaultModule\Controller\Error',
                    'DefaultModule\Controller\Sign',
                    'Myattendance\Controller\Index',
                    'Myattendance\Controller\Attendance',
                    'Myattendance\Controller\Vacation',
                    'Notifications\Controller\Index',
                    'Requests\Controller\Permission',
                    'Requests\Controller\Vacation',
                    'Requests\Controller\Workfromhome',
                ),
            ),
            "Admin" => array(
                "roles" => array(
                    "Admin",
                ),
                "resources" => array(
                    "Users\Controller\Index",
                    'Requests\Controller\Myrequests',
                    'Settings\Controller\Index',
                    'Settings\Controller\Vacation',
                    'Settings\Controller\Position',
                    'Settings\Controller\Holiday',
                    'Settings\Controller\Departments',
                    'Settings\Controller\Branches',
                    'Settings\Controller\Attendance',
                ),
            ),
            "Employee" => array(
                "roles" => array(
                    "Employee",
                ),
                "resources" => array(
                    'Requests\Controller\Myrequests',
                ),
                "privileges" => array(
                    "comment",
                    "cancel",
                    "approve",
                    "decline",
                    "viewall",
                ),
            ),
            "HR" => array(
                "roles" => array(
                    "HR",
                ),
                "resources" => array(
                    'Requests\Controller\Myrequests',
                ),
                "privileges" => array(
                    "comment",
                    "approve",
                    "decline",
                    "viewall",
                ),
            ),
            "Manager" => array(
                "roles" => array(
                    "Manager",
                ),
                "resources" => array(
                    'Requests\Controller\Myrequests',
                ),
                "privileges" => array(
                    "comment",
                    "approve",
                    "decline",
                    "viewall",
                ),
            ),
        ),
        "blacklist" => array(
            "roles" => array(
                "Employee",
                "HR",
                "Manager",
            ),
            "resources" => array(
                "Users\Controller\Index",
                'Settings\Controller\Index',
                'Settings\Controller\Vacation',
                'Settings\Controller\Position',
                'Settings\Controller\Holiday',
                'Settings\Controller\Departments',
                'Settings\Controller\Branches',
                'Settings\Controller\Attendance',
            )
        )
    )
);









