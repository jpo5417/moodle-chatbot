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
 * The task that provides a complete restore of mod_geniai is defined here.
 *
 * @package   mod_geniai
 * @copyright 2025 Eduardo Kraus https://eduardokraus.com/
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once("{$CFG->dirroot}/mod/geniai/backup/moodle2/restore_geniai_stepslib.php");

/**
 * The class provides a complete restore of mod_geniai.
 *
 * @package   mod_geniai
 * @copyright 2025 Eduardo Kraus https://eduardokraus.com/
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_geniai_activity_task extends restore_activity_task {

    /**
     * Defines particular settings that this activity can have.
     */
    protected function define_my_settings(): void {
        return;
    }

    /**
     * Defines particular steps that this activity can have.
     *
     * @return base_step.
     */
    protected function define_my_steps(): void {
        $this->add_step(new restore_geniai_activity_structure_step(
                "geniai_structure",
                "geniai.xml")
        );
    }

    /**
     * Defines the contents in the activity that must be processed by the link decoder.
     *
     * @return array.
     */
    public static function define_decode_contents(): array {
        $contents = [];

        // Define the contents.
        $contents[] = new restore_decode_content("geniai", ["intro"], "geniai");

        return $contents;
    }

    /**
     * Defines the decoding rules for links belonging to the activity to be executed by the link decoder.
     *
     * @return restore_decode_rule[].
     */
    public static function define_decode_rules(): array {
        $rules = [];

        $rules[] = new restore_decode_rule(
            "CERTIFICATEBEAUTIFULVIEWBYID", '/mod/geniai/view.php?id=$1', "course_module");
        $rules[] = new restore_decode_rule(
            "CERTIFICATEBEAUTIFULINDEX", '/mod/geniai/index.php?id=$1', "course");

        return $rules;
    }

    /**
     * Defines the restore log rules that will be applied by the
     * {@see restore_logs_processor} when restoring mod_geniai logs. It
     * must return one array of {@see restore_log_rule} objects.
     *
     * @return restore_log_rule[].
     */
    public static function define_restore_log_rules(): array {
        $rules = [];

        // Define the rules.
        $rules[] = new restore_log_rule("geniai", "view all", "index.php?id={course}", null);

        return $rules;
    }
}
