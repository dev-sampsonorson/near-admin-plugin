<div id="volunteerApplicationWrapper" class="mx-auto col-xl-6 col-lg-7 col-md-8 col-sm-11 c-volunteer-form">
    <form id="volunteerForm" class="c-volunteer-form__instance" data-parsley-errors-messages-disabled>
        <div class="py-4 c-volunteer-form__header">
            <h2>Volunteer Application Form</h2>
            <p class="lead c-volunteer-form__info">
                Fill in your personal details, availability, and volunteer interest
            </p>
        </div>
        <div id="volunteer-form-notification" class="alert alert-dismissible fade d-none" role="alert">
            <div class="alert-message"></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="c-volunteer-form__content">
            <h5 class="text-muted">Personal Details</h5>
            <div class="form-row">
                <div class="form-group col-4">
                    <label for="txtLastName" class="clearfix">Last Name <span
                              class="float-right text-danger">required</span></label>
                    <input type="text" id="txtLastName" name="volunteer[txtLastName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="form-group col-4">
                    <label for="txtFirstName" class="clearfix">First Name <span
                              class="float-right text-danger">required</span></label>
                    <input type="text" id="txtFirstName" name="volunteer[txtFirstName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="form-group col-4">
                    <label for="txtOtherName">Other Names</label>
                    <input type="text" id="txtOtherName" name="volunteer[txtOtherName]"
                           class="form-control form-control-sm" placeholder="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="txtMobileNumber" class="clearfix">Mobile Number <span
                              class="float-right text-danger">required</span></label>
                    <input type="text" id="txtMobileNumber" name="volunteer[txtMobileNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="form-group col-6">
                    <label for="txtEmailAddress" class="clearfix">Email Address <span
                              class="float-right text-danger">required</span></label>
                    <input type="email" id="txtEmailAddress" name="volunteer[txtEmailAddress]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label for="dtpBirthDate">Birth Date</label>
                    <input type="text" class="form-control form-control-sm date-control" id="dtpBirthDate"
                           name="volunteer[dtpBirthDate]" placeholder="YYYY-MM-DD" required data-parsley-dateformat
                           value="">
                </div>
                <div class="form-group col-6">
                    <label for="ddlGender">Gender</label>
                    <select class="custom-select custom-select-sm" name="volunteer[ddlGender]" id="ddlGender" required>
                        <option selected disabled value="">Select a gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="ddlStateOfOrigin">State of Origin</label>
                    <select class="custom-select custom-select-sm" name="volunteer[ddlStateOfOrigin]"
                            id="ddlStateOfOrigin" required>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="txtAddress">Address</label>
                    <input type="text" id="txtAddress" name="volunteer[txtAddress]" class="form-control form-control-sm"
                           placeholder="" required="" value="">
                </div>
            </div>
            <h5 id="availabilityTitle" class="my-4 text-muted">Availability - <small>at what times are you available
                    for
                    volunteering</small>
            </h5>
            <div id="availabilityWrapper" class="form-row">
                <div class="form-group col-6">
                    <div class="form-check">
                        <input id="chkMorningsMondayToFriday" name="volunteer[availability][]"
                               value="chkMorningsMondayToFriday" type="checkbox" class="form-check-input"
                               data-parsley-multiple="chkAvailability" required="" data-parsley-mincheck="1"
                               data-tebo-group-title="#availabilityTitle">
                        <label class="form-check-label" for="chkMorningsMondayToFriday">Mornings (Monday -
                            Friday)</label>
                    </div>
                    <div class="form-check">
                        <input id="chkEveningsMondayToFriday" name="volunteer[availability][]"
                               value="chkEveningsMondayToFriday" type="checkbox" class="form-check-input"
                               data-parsley-multiple="chkAvailability">
                        <label class="form-check-label" for="chkEveningsMondayToFriday">Evenings (Monday -
                            Friday)</label>
                    </div>
                    <div class="form-check">
                        <input id="chkOnceAWeek" name="volunteer[availability][]" value="chkOnceAWeek" type="checkbox"
                               class="form-check-input" data-parsley-multiple="chkAvailability">
                        <label class="form-check-label" for="chkOnceAWeek">Once a week</label>
                    </div>
                    <div class="form-check">
                        <input id="chkOneTimeOnly" name="volunteer[availability][]" value="chkOneTimeOnly"
                               type="checkbox" class="form-check-input" data-parsley-multiple="chkAvailability">
                        <label class="form-check-label" for="chkOneTimeOnly">One time only</label>
                    </div>

                </div>
                <div class="form-group col-6">
                    <div class="form-check">
                        <input id="chkAfternoonsMondayToFriday" name="volunteer[availability][]"
                               value="chkAfternoonsMondayToFriday" type="checkbox" class="form-check-input"
                               data-parsley-multiple="chkAvailability">
                        <label class="form-check-label" for="chkAfternoonsMondayToFriday">Afternoons (Monday -
                            Friday)</label>
                    </div>
                    <div class="form-check">
                        <input id="chkWeekends" name="volunteer[availability][]" value="chkWeekends" type="checkbox"
                               class="form-check-input" data-parsley-multiple="chkAvailability">
                        <label class="form-check-label" for="chkWeekends">Weekends</label>
                    </div>
                    <div class="form-check">
                        <input id="chkMoreThanOnceAWeek" name="volunteer[availability][]" value="chkMoreThanOnceAWeek"
                               type="checkbox" class="form-check-input" data-parsley-multiple="chkAvailability">
                        <label class="form-check-label" for="chkMoreThanOnceAWeek">More than once a week</label>
                    </div>
                    <div class="form-check">
                        <input id="chkAsNeeded" name="volunteer[availability][]" value="chkAsNeeded" type="checkbox"
                               class="form-check-input" data-parsley-multiple="chkAvailability">
                        <label class="form-check-label" for="chkAsNeeded">As Needed</label>
                    </div>

                </div>
            </div>
            <h5 id="volunteerInterestTitle" class="my-4 text-muted">Volunteer Interest - <small>please tick those
                    areas of
                    volunteering you are
                    interested
                    in</small></h5>
            <div class="form-row">
                <div class="form-group col-6">
                    <div class="form-check">
                        <input id="chkHungerReliefActivities" name="volunteer[interest][]"
                               value="chkHungerReliefActivities" type="checkbox" class="form-check-input"
                               data-parsley-multiple="chkVolunteerInterest" required="" data-parsley-mincheck="1"
                               data-tebo-group-title="#volunteerInterestTitle">
                        <label class="form-check-label" for="chkHungerReliefActivities">Hunger relief activities</label>
                    </div>
                    <div class="form-check">
                        <input id="chkHelpChildrenRead" name="volunteer[interest][]" value="chkHelpChildrenRead"
                               type="checkbox" class="form-check-input" data-parsley-multiple="chkVolunteerInterest">
                        <label class="form-check-label" for="chkHelpChildrenRead">Helping children read or reading
                            to them</label>
                    </div>
                    <div class="form-check">
                        <input id="chkMentoringTeens" name="volunteer[interest][]" value="chkMentoringTeens"
                               type="checkbox" class="form-check-input" data-parsley-multiple="chkVolunteerInterest">
                        <label class="form-check-label" for="chkMentoringTeens">Mentoring Teens</label>
                    </div>
                    <div class="form-check">
                        <input id="chkOrphanageVisiting" name="volunteer[interest][]" value="chkOrphanageVisiting"
                               type="checkbox" class="form-check-input" data-parsley-multiple="chkVolunteerInterest">
                        <label class="form-check-label" for="chkOrphanageVisiting">Orphanage visiting</label>
                    </div>
                </div>
                <div class="form-group col-6">
                    <div class="form-check">
                        <input id="chkArtCraftActivityInstructor" name="volunteer[interest][]"
                               value="chkArtCraftActivityInstructor" type="checkbox" class="form-check-input"
                               data-parsley-multiple="chkVolunteerInterest">
                        <label class="form-check-label" for="chkArtCraftActivityInstructor">Arts &amp; Craft
                            activity instructor/assistant</label>
                    </div>
                    <div class="form-check">
                        <input id="chkAssistingWithFundraising" name="volunteer[interest][]"
                               value="chkAssistingWithFundraising" type="checkbox" class="form-check-input"
                               data-parsley-multiple="chkVolunteerInterest">
                        <label class="form-check-label" for="chkAssistingWithFundraising">Assisting with
                            fundraising</label>
                    </div>
                    <div class="form-check">
                        <input id="chkCharityShop" name="volunteer[interest][]" value="chkCharityShop" type="checkbox"
                               class="form-check-input" data-parsley-multiple="chkVolunteerInterest">
                        <label class="form-check-label" for="chkCharityShop">Charity shop</label>
                    </div>
                    <div class="form-check">
                        <input id="chkCommunityWork" name="volunteer[interest][]" value="chkCommunityWork"
                               type="checkbox" class="form-check-input" data-parsley-multiple="chkVolunteerInterest">
                        <label class="form-check-label" for="chkCommunityWork">Community work</label>
                    </div>
                </div>
            </div>
            <div class="flex-column form-row d-flex flex-sm-row" style="margin-left: 1px; margin-right: -1px;">
                <div class="form-check">
                    <input id="chkInterestTutoring" name="volunteer[interest][]" value="chkInterestTutoring"
                           type="checkbox" class="form-check-input" data-parsley-multiple="chkVolunteerInterest">
                    <label class="form-check-label" for="chkInterestTutoring">Tutoring</label>
                </div>
                <div class="flex-sm-grow-1">
                    <div class="mt-2 form-group mt-sm-0 ml-sm-4">
                        <input type="text" id="txtInterestTutoringDetail"
                               name="volunteer[interest][chkInterestTutoring][txtInterestTutoringDetail]"
                               class="form-control form-control-sm" placeholder="" data-parsley-validate-if-empty
                               data-parsley-require-if="#chkInterestTutoring">
                    </div>
                </div>
            </div>
            <div class="flex-column form-row d-flex" style="margin-left: 1px; margin-right: -1px;">
                <div class="form-check">
                    <input id="chkNotListedActivityOfInterest" name="volunteer[interest][]"
                           value="chkNotListedActivityOfInterest" type="checkbox" class="form-check-input"
                           data-parsley-multiple="chkVolunteerInterest">
                    <label class="form-check-label" for="chkNotListedActivityOfInterest">Activities not listed that i am
                        interested in</label>
                </div>
                <div class="flex-sm-grow-1">
                    <div class="mt-2 form-group">
                        <input type="text" id="txtNotListedActivityOfInterest"
                               name="volunteer[interest][chkNotListedActivityOfInterest][txtNotListedActivityOfInterest]"
                               class="form-control form-control-sm" placeholder="" data-parsley-validate-if-empty
                               data-parsley-require-if="#chkNotListedActivityOfInterest">
                    </div>
                </div>
            </div>

            <div class="c-volunteer-form__buttons d-flex justify-content-end">
                <button id="btnCancel" type="button"
                        class="btn btn-secondary c-volunteer-form__button c-volunteer-form__button--cancel">
                    <span class="">Cancel</span>
                </button>
                <button id="btnSave" type="button"
                        class="ml-2 btn btn-secondary c-volunteer-form__button c-volunteer-form__button--save">
                    <span class="">Save</span>
                </button>
            </div>
        </div>
    </form>
</div>
