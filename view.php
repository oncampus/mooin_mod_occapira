<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of occapira
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod
 * @subpackage occapira
 * @copyright  2015 oncampus
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // occapira instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('occapira', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $occapira  = $DB->get_record('occapira', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $occapira  = $DB->get_record('occapira', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $occapira->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('occapira', $occapira->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = get_context_instance(CONTEXT_MODULE, $cm->id);

add_to_log($course->id, 'occapira', 'view', "view.php?id={$cm->id}", $occapira->name, $cm->id);

/// Print the page header

$PAGE->set_url('/mod/occapira/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($occapira->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// other things you may want to set - remove if not needed
//$PAGE->set_cacheable(false);
//$PAGE->set_focuscontrol('some-html-id');
//$PAGE->add_body_class('occapira-'.$somevar);

// Output starts here
echo $OUTPUT->header();

if ($occapira->intro) { // Conditions to show the intro can change to look for own settings or whatever
    echo $OUTPUT->box(format_module_intro('occapira', $occapira, $cm->id), 'generalbox mod_introbox', 'occapiraintro');
}

// Replace the following lines with you own code
echo $OUTPUT->heading('Yay! It works!');

// Finish the page
echo $OUTPUT->footer();
