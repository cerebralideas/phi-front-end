## Version 0.9.0-alpha

### New

1. Added select for type of insurance to correlate with CMS-1500 field 1.

### Fixed

1. Fixed insurance fields not showing up in submitted reports.
1. Fixed a bug in the date search in Calendar tab.
1. Fixed sidebar not displaying on out-patient superbills.
1. Fix duplicate submit function.

### Planned

1. Add patient ledger functionality.
1. Add better feedback on time slot selection in Scheduler.
1. Add apt length validation for chosen time slot in Scheduler.
1. Improve Scheduler integration with Apt form.
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.
1. Status History needs to be written for submitted item history.

--------------------------

## Version 0.8.0-alpha

### New

1. "Date of Initial Sx, Acc or LMP" has been added to the superbill form.
1. "Prior Authorization Number" has been added to the superbill form.
1. Front-end for the claims tab is now active.
1. Front-end for the claim form is completed.

### Fixed

1. Moved "Reference Number" from superbill to claim form.

### Planned

1. Fix duplicate submit function
1. Add select for type of insurance to correlate with CMS-1500 field 1.
1. Add better feedback on time slot selection in Scheduler.
1. Add apt length validation for chosen time slot in Scheduler.
1. Improve Scheduler integration with Apt form.
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.
1. Status History needs to be written for submitted item history.

--------------------------

## Version 0.7.2-beta

### New

1. Superbills can now be submitted and reviewed.
1. When creating a superbill from an existing apt, only apts *not* associated with a superbill will be available.

### Fixed

1. Superbill submit bug is fixed
1. Submitted superbill bug that provided all null values for patient info for faculty is fixed.
1. Superbill bug that prevented submission of multiple diagnosis and procedure codes is fixed.
1. Form sections have been tightened up a bit.

### Planned

1. Fix duplicate submit function
1. Add select for type of insurance to correlate with CMS-1500 field 1.
1. Add better feedback on time slot selection in Scheduler.
1. Add apt length validation for chosen time slot in Scheduler.
1. Improve Scheduler integration with Apt form.
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.
1. Status History needs to be written for submitted item history.

--------------------------

## Version 0.7.1-beta

### New

1. Preview generated superbill now available.

### Fixed

1. Fixed bug that prevented using a new appointment with superbill
1. Fixed bug that prevented the save feedback from showing upon superbill save.

### Planned

1. Tighten up design of "Generated Superbill"
1. Fix duplicate submit function
1. Add submitted superbills to All Activity for review
1. Add select for type of insurance to correlate with CMS-1500 field 1.
1. Add better feedback on time slot selection in Scheduler.
1. Add apt length validation for chosen time slot in Scheduler.
1. Improve Scheduler integration with Apt form.
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.

--------------------------

## Version 0.7.0-beta

### New

1. Superbills and Claims are now separated into respective tabs
1. Procedure modifier codes are not searchable in modal window
1. Procedure codes now have prices
1. Diagnosis codes can now be resorted
1. Diagnostic codes can now be re-ordered
1. Both procedure and diagnosis codes can be removed from list

### Fixed

1. Submit now saves the item first, then submits.
1. Authorization notes from appointment are now carried over into superbill automatically.

### Planned

1. Add select for type of insurance to correlate with CMS-1500 field 1.
1. Add better feedback on time slot selection in Scheduler.
1. Add apt length validation for chosen time slot in Scheduler.
1. Improve Scheduler integration with Apt form.
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.

---------------------------

## Version 0.6.1-beta

### New

1. Appointments are now sorted by appropriate date in Patient > Appointment tab.
1. Added more options to appointment status.

### Fixed

1. Better Appointment organization in Patient > Appointment tab.
1. Fixed wording on Current Insurance checkbox.
1. Fixed age calculations to handle age less than 1 year.
1. Much more powerful search with multiple search parameters for Patient tab.
1. Much more powerful search for Calendar with date range and patient name parameter.

### Planned

1. Add better feedback on time slot selection in Scheduler.
1. Add apt length validation for chosen time slot in Scheduler.
1. Improve Scheduler integration with Apt form.
1. Improve search functionality to allow multiple search points; e.g. search for both first and last name or both last name and MRN at the same time.
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.
1. Improve performance.

---------------------------

## Version 0.5.5-beta

### New

1. A very early, beta release of the Scheduler has now been added as a module to the appointment form in both the Patient tab and the Calendar tab. It can be found as a link just above the start time and date inputs on the appointment form.
1. Added Referring Provider and Referring Provider ID Number to appointment form.
1. Added Pt Condition Related To select to appointment form.

### Fixed

1. Fixed a bug that was in the Calendar tab when selecting a provider within an appointment tab.
1. Fixed some performance issues.

### Planned

1. Continue to improve the scheduler feature in response to feedback.
1. Improve search functionality to allow multiple search points; e.g. search for both first and last name or both last name and MRN at the same time.
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.
1. Improve performance.

-----------------------------

## Version 0.4.2-beta

### New

1. Appointments and Admissions tab within a patient file is now available
1. User can create and edit appointments/admissions within patient file
1. Top level Calendar tab is now available and appointments/admissions can be created and edited there
1. All activity tab now has Appointments and Admissions for reviewing
1. When creating an event within the Calendar tab, the event list view is changed to the date of the newly created event.
1. Extended date validation to check for accidental typos (e.g. 09/31/2012)
1. Added warning message for dates that pass formatting validation, but are invalid dates
1. Unit testing is now being integrated into application

### Fixed

1. Comment box bug was fixed for admissions in all-activity
1. Moving forward and backward in calender view now works as expected when moving between months
1. Fixed Sex selection bug in pt registration
1. More precise date calculations and management with Calendar tab

### Planned

1. More robust scheduling function that extends the appointment/admission functionality
1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.

------------------------------

## Version 0.3.3-beta

### New

1. Added "Plan ID" which is optional and used on the UB-04 form
1. Added "Group Name" which is optional and used on the UB-04 form
1. Added a bit more visual structure to the Insurance Section
1. Added "Suffix" for Jr, Sr, et cetera
1. Selects are now shown as native elements

### Fixed

1. Removed Uniform plugin for selects which caused bugs and performance issues
1. Insurance fields now map to both CMS-1500 and UB-04 forms
1. Validation tooltips are no longer hidden for selects
1. Select onfocus and error borders now show
1. Fixed style bug in user menu for student role
1. Fixed bug that prevented new patient registration
1. Fixed bug that didn't allow emptying of data fields
1.

### Planned

1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Better error messaging for validation issues, empty required fields …
1. Validation and formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.

-----------------------

## Version 0.2.1-beta

### New

1. Phone Number Validation and Formatting is now working.
1. Placeholders shown when input is focused.
1. Added a phone number field to parent/guardian contacts

### Fixed

1. Fixed bug that didn't format date when clicked-out of the field, rather than tabbed-out.

### Planned

1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Validation and formatting for Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.

------------------------

## Version 0.2.0-beta

### New

1. Choosing "Self" now auto-populates the corresponding fields with the patient information.
1. Some sections are only shown if the section is relevant to the patient. Choosing "Yes" will reveal the needed form for adding data.
1. Added "Status Updates" for communicated changes to the software to beta testers.
1. Added "Employment Status" to the Patient Information section.
1. Added "Employer" and "Employer Phone" to the "Policy Holder" section of insurance.

### Fixed

1. Changed "Company" under insurance to "Insurance Company".
1. Changed "Insured" to "Policy Holder".
1. Added "Other" to "Marriage Status".
1. Changed form design to add a bit more distinction between sections and clarity of sub-sections.

### Planned

1. Selecting Father or Mother for guarantor or policy holder will auto-populate corresponding fields with data captured from Parent/Guardian section.
1. Validation and formatting for Phone numbers and Social Security numbers.
1. Current section identifier and "Quick Links" to sections within form.

-------------------------

## Version 0.1.3-beta

### New

1. Added user type to user greeting in User Controls.

### Fixed

1. Date validation and formatting is now in effect on all date inputs.
1. Switching user modes is now working for administrators.
1. Concatenated JS scripts for faster performance.