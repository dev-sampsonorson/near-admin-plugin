<div id="scholarshipApplicationWrapper" class="mx-auto col-xl-7 col-lg-7 col-md-9 col-sm-11 c-scholarship-form">

    <form id="scholarshipForm" class="c-scholarship-form__instance" data-parsley-focus="none"
          data-parsley-errors-messages-disabled enctype="multipart/form-data">
        <div class="py-4 c-scholarship-form__header">
            <h2>Scholarship Application Form</h2>
            <p class="lead c-scholarship-form__info">
                Provide your personal, bank account, education, family information. Including necessary supporting
                documents.
            </p>
        </div>
        <div id="scholarship-form-notification" class="alert alert-dismissible fade d-none" role="alert">
            <div class="alert-message"></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="c-scholarship-form__content">
            <h5 class="text-muted">Personal</h5>
            <div class="form-row">
                <div class="col-12 form-group col-sm-4">
                    <label for="txtLastName">Last Name</label>
                    <input type="text" id="txtLastName" name="scholarship[txtLastName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-4 ">
                    <label for="txtFirstName">First Name</label>
                    <input type="text" id="txtFirstName" name="scholarship[txtFirstName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-4">
                    <label for="txtOtherName">Other Names</label>
                    <input type="text" id="txtOtherName" name="scholarship[txtOtherName]"
                           class="form-control form-control-sm" placeholder="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-sm-4">
                    <label for="txtNationalIdNumber">National ID Number</label>
                    <input type="text" id="txtNationalIdNumber" name="scholarship[txtNationalIdNumber]"
                           class="form-control form-control-sm" placeholder="" value="">
                </div>
                <div class="form-group col-12 col-sm-4">
                    <label for="txtBirthPlace">Birth Place</label>
                    <input type="text" id="txtBirthPlace" name="scholarship[txtBirthPlace]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="form-group col-12 col-sm-4">
                    <label for="dtpBirthDate">Birth Date</label>
                    <input type="text" class="form-control form-control-sm date-control" id="dtpBirthDate"
                           name="scholarship[dtpBirthDate]" placeholder="YYYY-MM-DD" required="" data-parsley-dateformat
                           value="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12 col-sm-4">
                    <label for="txtEmailAddress">Email Address</label>
                    <input type="text" id="txtEmailAddress" name="scholarship[txtEmailAddress]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="form-group col-12 col-sm-4">
                    <label for="txtMobileNumber">Mobile</label>
                    <input type="text" id="txtMobileNumber" name="scholarship[txtMobileNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="form-group col-12 col-sm-4">
                    <label for="txtParentsPhone">Parent's Phone</label>
                    <input type="text" id="txtParentsPhone" name="scholarship[txtParentsPhone]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <div class="form-row">
                <div id="scholarshipBeneficiaryTitle" class="mb-2 col-12">
                    Did you get scholarship from our foundation last year?
                </div>
                <div class="mb-3 col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="rbLastYearScholarshipYes"
                               name="scholarship[rbLastYearScholarship]" value="true" required=""
                               data-tebo-group-title="#scholarshipBeneficiaryTitle">
                        <label class="form-check-label" for="rbLastYearScholarshipYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="rbLastYearScholarshipNo"
                               name="scholarship[rbLastYearScholarship]" value="false">
                        <label class="form-check-label" for="rbLastYearScholarshipNo">No</label>
                    </div>
                </div>
            </div>
            <div id="scholarshipTypeWrapper" class="form-row">
                <div id="scholarshipTypeTitle" class="mb-2 col-12">
                    Type of scholarship required
                </div>
                <div class="mb-3 col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="chkScholarshipReqAccomodation"
                               name="scholarship[scholarshipType][]" value="chkScholarshipReqAccomodation"
                               data-parsley-multiple="chkScholarshipType" required="" data-parsley-mincheck="1"
                               data-tebo-group-title="#scholarshipTypeTitle">
                        <label class="form-check-label" for="chkScholarshipReqAccomodation">Accomodation</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="chkScholarshipReqTuition"
                               name="scholarship[scholarshipType][]" value="chkScholarshipReqTuition"
                               data-parsley-multiple="chkScholarshipType">
                        <label class="form-check-label" for="chkScholarshipReqTuition">Tuition</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="chkScholarshipReqMonthlyAllowance"
                               name="scholarship[scholarshipType][]" value="chkScholarshipReqMonthlyAllowance"
                               data-parsley-multiple="chkScholarshipType">
                        <label class="form-check-label" for="chkScholarshipReqMonthlyAllowance">Monthly
                            Allowance</label>
                    </div>
                </div>
            </div>
            <!-- <div class="form-row">
                <div class="form-group col-12">
                    <label for="txtFileId">File ID</label>
                    <input type="text" id="txtFileId" name="scholarship[txtFileId]" class="form-control form-control-sm"
                           placeholder="" required="" value="000001">
                </div>
            </div> -->
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
                    <label for="txtAddress" class="form-label">Address</label>
                    <input type="text" id="txtAddress" name="scholarship[txtAddress]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="txtHowKnowFoundation" class="form-label">How did you know about our
                        foundation?</label>
                    <input type="text" id="txtHowKnowFoundation" name="scholarship[txtHowKnowFoundation]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <h5 class="text-muted">Bank Account</h5>
            <div class="form-row">
                <div class="col-12 form-group col-sm-6">
                    <label for="txtBankName" class="clearfix">Bank Name <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtBankName" name="scholarship[txtBankName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-6">
                    <label for="txtBankAccountName" class="clearfix">Account Name <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtBankAccountName" name="scholarship[txtBankAccountName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 form-group col-sm-6">
                    <label for="txtAccountNumber" class="clearfix">Account Number <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtAccountNumber" name="scholarship[txtAccountNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-6">
                    <label for="txtIbanNumber" class="clearfix">IBAN Number <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtIbanNumber" name="scholarship[txtIbanNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <h5 class="mt-4 text-muted">Educational Background</h5>
            <div class="form-row">
                <div id="educationLevelTitle" class="mb-2 col-12">
                    Level of Education
                </div>
                <div class="mb-3 col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="chkEduPrimary"
                               name="scholarship[educationLevel][]" value="chkEduPrimary"
                               data-parsley-multiple="chkEducationLevel" required="" data-parsley-mincheck="1"
                               data-tebo-group-title="#educationLevelTitle">
                        <label class="form-check-label" for="chkEduPrimary">Primary</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="chkEduSecondary"
                               name="scholarship[educationLevel][]" data-parsley-multiple="chkEducationLevel"
                               value="chkEduSecondary">
                        <label class="form-check-label" for="chkEduSecondary">Secondary</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="chkEduUniversity"
                               name="scholarship[educationLevel][]" data-parsley-multiple="chkEducationLevel"
                               value="chkEduUniversity">
                        <label class="form-check-label" for="chkEduUniversity">University</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 form-group col-sm-4">
                    <label for="txtEduSchoolName">School Name</label>
                    <input type="text" id="txtEduSchoolName" name="scholarship[txtEduSchoolName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-4">
                    <label for="txtEduDepartment">Department</label>
                    <input type="text" id="txtEduDepartment" name="scholarship[txtEduDepartment]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-4">
                    <label for="txtEduClass">Class</label>
                    <input type="text" id="txtEduClass" name="scholarship[txtEduClass]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 form-group col-sm-6">
                    <label for="txtEduCity">City (Local Government)</label>
                    <input type="text" id="txtEduCity" name="scholarship[txtEduCity]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-6">
                    <label for="txtEduState">State</label>
                    <input type="text" id="txtEduState" name="scholarship[txtEduState]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <h5 class="mt-4 text-muted">Family Information</h5>
            <div class="form-row">
                <div class="col-12 col-sm-6">
                    <div class="flex-column d-flex">
                        <h6 class="mb-4 uppercase text-secondary">Mother</h6>
                        <div class="form-group">
                            <label for="txtFamilyMotherName" class="clearfix">Name <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyMotherName" name="scholarship[txtFamilyMotherName]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-row">
                            <div id="aliveOrDeceasedMotherTitle" class="clearfix mb-2 col-12">
                                Alive/Deceased
                                <span class="float-right text-danger small">required</span>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="rbFamilyMotherAlive"
                                           name="scholarship[rbFamilyMotherAlive]" value="alive" required=""
                                           data-tebo-group-title="#aliveOrDeceasedMotherTitle">
                                    <label class="form-check-label" for="rbFamilyMotherAlive">Alive</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="rbFamilyMotherDeceased"
                                           name="scholarship[rbFamilyMotherDeceased]" value="deceased">
                                    <label class="form-check-label" for="rbFamilyMotherDeceased">Deceased</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyMotherOccupation" class="clearfix">Occupation <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyMotherOccupation"
                                   name="scholarship[txtFamilyMotherOccupation]" class="form-control form-control-sm"
                                   placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyMotherIncome" class="clearfix">Monthly Income <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyMotherIncome" name="scholarship[txtFamilyMotherIncome]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyMotherCity" class="clearfix">City <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyMotherCity" name="scholarship[txtFamilyMotherCity]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyMotherState" class="clearfix">State (Local Government) <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyMotherState" name="scholarship[txtFamilyMotherState]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyMotherMobileNumber" class="clearfix">Mobile Number <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyMotherMobileNumber"
                                   name="scholarship[txtFamilyMotherMobileNumber]" class="form-control form-control-sm"
                                   placeholder="" required="" value="">
                        </div>

                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="flex-column d-flex">
                        <h6 class="mb-4 uppercase text-secondary">Father</h6>
                        <div class="form-group">
                            <label for="txtFamilyFatherName" class="clearfix">Name <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyFatherName" name="scholarship[txtFamilyFatherName]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-row">
                            <div id="aliveOrDeceasedFatherTitle" class="clearfix mb-2 col-12">
                                Alive/Deceased 
                                <span class="float-right text-danger small">required</span>
                            </div>
                            <div class="mb-3 col-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="rbFamilyFatherAlive"
                                           name="scholarship[rbFamilyFatherAlive]" value="alive" required=""
                                           data-tebo-group-title="#aliveOrDeceasedFatherTitle">
                                    <label class="form-check-label" for="rbFamilyFatherAlive">Alive</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="rbFamilyFatherDeceased"
                                           name="scholarship[rbFamilyFatherDeceased]" value="deceased">
                                    <label class="form-check-label" for="rbFamilyFatherDeceased">Deceased</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyFatherOccupation" class="clearfix">Occupation <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyFatherOccupation"
                                   name="scholarship[txtFamilyFatherOccupation]" class="form-control form-control-sm"
                                   placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyFatherIncome" class="clearfix">Monthly Income <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyFatherIncome" name="scholarship[txtFamilyFatherIncome]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyFatherCity" class="clearfix">City <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyFatherCity" name="scholarship[txtFamilyFatherCity]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyFatherState" class="clearfix">State (Local Government) <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyFatherState" name="scholarship[txtFamilyFatherState]"
                                   class="form-control form-control-sm" placeholder="" required="" value="">
                        </div>
                        <div class="form-group">
                            <label for="txtFamilyFatherMobileNumber" class="clearfix">Mobile Number <span class="float-right text-danger">required</span></label>
                            <input type="text" id="txtFamilyFatherMobileNumber"
                                   name="scholarship[txtFamilyFatherMobileNumber]" class="form-control form-control-sm"
                                   placeholder="" required="" value="">
                        </div>

                    </div>
                </div>
            </div>
            <h5 class="mt-4 text-muted">Siblings Information</h5>
            <div class="form-row">
                <div class="col-12 form-group col-sm-6">
                    <label for="txtSiblingNumber">Number of Siblings</label>
                    <input type="text" id="txtSiblingNumber" name="scholarship[txtSiblingNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-6">
                    <label for="txtSiblingPrimarySchNumber">The Number of Those in Primary</label>
                    <input type="text" id="txtSiblingPrimarySchNumber" name="scholarship[txtSiblingPrimarySchNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 form-group col-sm-6">
                    <label for="txtSiblingSecondarySchNumber">The Number of Those in Secondary</label>
                    <input type="text" id="txtSiblingSecondarySchNumber"
                           name="scholarship[txtSiblingSecondarySchNumber]" class="form-control form-control-sm"
                           placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-6">
                    <label for="txtSiblingUniversityNumber">The Number of Those in University</label>
                    <input type="text" id="txtSiblingUniversityNumber" name="scholarship[txtSiblingUniversityNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <hr class="my-4">
            <div class="form-row">
                <div id="volunteerParticipationTitle" class="mb-2 col-12">
                    Do you want to participate in our foundation's activities as a volunteer?
                </div>
                <div class="mb-3 col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="rbVolunteerParticipationYes"
                               name="scholarship[rbVolunteerParticipation]" value="true" required=""
                               data-tebo-group-title="#volunteerParticipationTitle">
                        <label class="form-check-label" for="rbVolunteerParticipationYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="rbVolunteerParticipationNo"
                               name="scholarship[rbVolunteerParticipation]" value="false">
                        <label class="form-check-label" for="rbVolunteerParticipationNo">No</label>
                    </div>
                </div>
            </div>
            <h5 class="mt-4 text-muted">Documents Required - <small>PDF, 1MB max</small></h5>
            <div class="form-row">
                <div class="col-12 col-sm-6">
                    <div class="d-flex flex-column">
                        <div class="form-group">
                            <label id="lblPassportPhotograph" class="mb-2 form-check-label"
                                   for="filePassportPhotograph">Passport
                                Photograph</label>
                            <input id="filePassportPhotograph" name="scholarship[filePassportPhotograph]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblPassportPhotograph">
                        </div>
                        <div class="form-group">
                            <label id="lblRequestLetter" class="mb-2 form-check-label" for="fileRequestLetter">Request
                                Letter</label>
                            <input id="fileRequestLetter" name="scholarship[fileRequestLetter]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblRequestLetter">
                        </div>
                        <div class="form-group">

                            <label id="lblAdmissionLetter" class="mb-2 form-check-label"
                                   for="fileAdmissionLetter">Admission Letter</label>
                            <input id="fileAdmissionLetter" name="scholarship[fileAdmissionLetter]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblAdmissionLetter">
                        </div>
                        <div class="form-group">

                            <label id="lblJambResult" class="mb-2 form-check-label" for="fileJambResult">JAMB
                                Result</label>
                            <input id="fileJambResult" name="scholarship[fileJambResult]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblJambResult">
                        </div>
                        <div class="form-group">
                            <label id="lblWaecResult" class="mb-2 form-check-label" for="fileJambResult">WAEC
                                Result</label>
                            <input id="fileWaecResult" name="scholarship[fileWaecResult]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblWaecResult">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="d-flex flex-column">
                        <div class="form-group">
                            <label id="lblMatriculationNumber" class="mb-2 form-check-label"
                                   for="fileMatriculationNumber">Matriculation Number</label>
                            <input id="fileMatriculationNumber" name="scholarship[fileMatriculationNumber]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblMatriculationNumber">
                        </div>
                        <div class="form-group">
                            <label id="lblIndigeneCertificate" class="mb-2 form-check-label"
                                   for="fileIndigeneCertificate">Indigene
                                Certificate</label>
                            <input id="fileIndigeneCertificate" name="scholarship[fileIndigeneCertificate]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblIndigeneCertificate">
                        </div>
                        <div class="form-group">
                            <label id="lblBirthCertificate" class="mb-2 form-check-label"
                                   for="fileBirthCertificate">Birth Certificate</label>
                            <input id="fileBirthCertificate" name="scholarship[fileBirthCertificate]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblBirthCertificate">
                        </div>
                        <div class="form-group">
                            <label id="lblValidIdCard" class="mb-2 form-check-label" for="fileValidIdCard">Valid ID
                                Card</label>
                            <input id="fileValidIdCard" name="scholarship[fileValidIdCard]" type="file"
                                   class="form-control-file" required="" data-parsley-allowed-file-type="pdf"
                                   data-parsley-max-file-size="1000" data-tebo-group-title="#lblValidIdCard">
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="form-row">
                <div class="mb-2 col-12">
                    Why are you applying for the scholarship?
                </div>
                <div class="mb-3 col-12">
                    <div class="form-group">
                        <textarea class="form-control" id="txtWhyScholarship" name="scholarship[txtWhyScholarship]"
                                  rows="3" required=""></textarea>
                    </div>
                </div>
            </div>
            <h5 class="mt-4 text-muted">Reference Information</h5>
            <div class="form-row">
                <div class="col-12 form-group col-sm-4">
                    <label for="txtRefLastName" class="clearfix">Last Name <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtRefLastName" name="scholarship[txtRefLastName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-4">
                    <label for="txtRefFirstName" class="clearfix">First Name <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtRefFirstName" name="scholarship[txtRefFirstName]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-4">
                    <label for="txtRefOtherName" class="clearfix">Other Names <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtRefOtherName" name="scholarship[txtRefOtherName]"
                           class="form-control form-control-sm" placeholder="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 form-group col-sm-6">
                    <label for="txtRefOccupation" class="clearfix">Occupation <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtRefOccupation" name="scholarship[txtRefOccupation]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
                <div class="col-12 form-group col-sm-6">
                    <label for="txtRefPosition" class="clearfix">Position <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtRefPosition" name="scholarship[txtRefPosition]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 form-group">
                    <label for="txtRefAddress" class="clearfix form-label">Address <span class="float-right text-danger">required</span></label>
                    <textarea class="form-control" id="txtRefAddress" name="scholarship[txtRefAddress]" rows="2"
                              required=""></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="col-12 form-group">
                    <label for="txtRefPhoneNumber" class="clearfix">Phone Number <span class="float-right text-danger">required</span></label>
                    <input type="text" id="txtRefPhoneNumber" name="scholarship[txtRefPhoneNumber]"
                           class="form-control form-control-sm" placeholder="" required="" value="">
                </div>
            </div>
            <hr class="my-4">
            <div class="form-row">
                <div class="col-12">
                    <p class="text-muted">I testify that the provided information above is correct. I accept the
                        cancellation of my scholarship and any legal action against me in case of any false
                        information.</p>

                    <p class="text-muted">I willingly marked the above options for contributing the welfare actions
                        of NTIC
                        Foundation. I will fullfil my responsibilities regarding my choices.</p>
                </div>
                <div class="mb-3 col-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="chkIAgree" name="scholarship[chkIAgree]"
                               value="true" required="">
                        <label class="form-check-label" for="chkIAgree">I agree</label>
                    </div>
                </div>
            </div>

            <div class="my-4 c-scholarship-form__buttons d-flex justify-content-end">
                <button id="btnCancel" type="button"
                        class="btn btn-secondary c-scholarship-form__button c-scholarship-form__button--cancel">
                    <span class="">Cancel</span>
                </button>
                <button id="btnSave" type="button"
                        class="ml-2 btn btn-secondary c-scholarship-form__button c-scholarship-form__button--save">
                    <span class="">Save</span>
                </button>
            </div>
        </div>
    </form>
</div>
