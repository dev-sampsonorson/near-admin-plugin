<?php
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $pageUrl = "https://";   
    else  
         $pageUrl = "http://";   
    
    $pageUrl .= $_SERVER['HTTP_HOST']; 
    $pageUrl .= $_SERVER['REQUEST_URI'];

    $reportRepo = new ReportRepo();
    $wpPage = isset($_GET["page"]) ? $_GET["page"] : "";
    $pageNumber = isset($_GET[NEAR_FOUNDATION_PAGE_QUERY_PARAM]) ? intval($_GET[NEAR_FOUNDATION_PAGE_QUERY_PARAM]) : 1;
    
    $queryType = isset($_GET[NEAR_FOUNDATION_QUERY_TYPE]) ? $_GET[NEAR_FOUNDATION_QUERY_TYPE] : NEAR_FOUNDATION_QUERY_TYPE_ALL;    
    $searchTerm = isset($_GET[NEAR_FOUNDATION_SEARCH_QUERY_PARAM]) && !empty($_GET[NEAR_FOUNDATION_SEARCH_QUERY_PARAM]) ? $_GET[NEAR_FOUNDATION_SEARCH_QUERY_PARAM] : "";
    $queryType = empty($searchTerm) ? NEAR_FOUNDATION_QUERY_TYPE_ALL : NEAR_FOUNDATION_QUERY_TYPE_SEARCH;
    
    $scholarshipAppsReport = $reportRepo->getScholarshipAppsReport($searchTerm, $pageNumber, NEAR_FOUNDATION_DEFAULT_PAGE_SIZE);
?>

<div class="text-gray-500" id="management-center-wrapper">
    <div class="mt-6 sm:px-1">
        <h3 class="text-lg font-medium">Scholarship Applications</h3>
        <p>
            This plugin provides users with the ability to submit volunteer and scholarship application, and make
            donations.
            Administrators can view the applications and donations for this management center.
        </p>
    </div>
    <div class="px-3 py-5 near-tab__content-wrapper" id="mgtCenterTabContent">
        <div class="pb-5 pr-2 border-b border-gray-200 sm:flex sm:items-center sm:justify-end">
            <div class="mt-3 sm:mt-0 sm:ml-4 sm:flex sm:items-center">
                <form class="search-form" method="get"
                      action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . $_GET['page']; ?>">
                    <p class="search-box">
                        <label class="screen-reader-text" for="txtSearchPurchaseReport">Search Report:</label>
                        <input type="search" id="<?php echo NEAR_FOUNDATION_SEARCH_QUERY_PARAM; ?>"
                               class="wp-filter-search" name="<?php echo NEAR_FOUNDATION_SEARCH_QUERY_PARAM; ?>"
                               value="<?php echo !empty($searchTerm) ? $searchTerm : ""; ?>"
                               placeholder="Email or Mobile Number" aria-describedby="live-search-desc">
                        <input type="submit" id="search-submit" class="button-primary" value="Search">
                        <input type="hidden" name="page" value="<?php echo $wpPage; ?>" />
                        <input type="hidden" name="<?php echo NEAR_FOUNDATION_QUERY_TYPE; ?>"
                               value="<?php echo NEAR_FOUNDATION_QUERY_TYPE_SEARCH; ?>" />
                    </p>
                </form>
                <a href="<?php echo $_SERVER['PHP_SELF'] . '?page=' . $_GET['page']; ?>"
                   class="all button-secondary ml-1">All</a>
            </div>

        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-5">
                <?php if (count($scholarshipAppsReport->result) > 0) { ?>
                <div class="inline-block min-w-full py-2 align-middle sm:pl-3 sm:pr-5">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table id="tblRecords" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Phone
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Parent Number
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">View</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach($scholarshipAppsReport->result as $row) { ?>
                                <tr data-record-id="<?php echo $row->getId(); ?>" class="align-top">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo $row->applicantName; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <?php echo $row->emailAddress; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <?php echo $row->mobileNumber; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <?php echo $row->parentNumber; ?></td>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <a id="<?php echo "view-" . $row->getId(); ?>"
                                           data-record-id="<?php echo $row->getId(); ?>" data-record-type="scholarship"
                                           href="#" class="text-indigo-600 view-record hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <nav class="flex items-center justify-between sm:ml-3 sm:mr-5 py-3 px-5 bg-white border-t border-gray-200 sm:rounded-lg"
                     aria-label="Pagination">
                    <div class="hidden sm:block">
                        Showing
                        <span class="font-medium"><?php echo $scholarshipAppsReport->startRecord; ?></span>
                        to
                        <span class="font-medium"><?php echo $scholarshipAppsReport->endRecord; ?></span>
                        of
                        <span class="font-medium"><?php echo $scholarshipAppsReport->recordTotal; ?></span>
                        results
                    </div>
                    <div class="flex justify-between flex-1 sm:justify-end">
                        <?php if($pageNumber > 1): ?>
                        <a href="<?php echo Helper::mergeQueryString($pageUrl, '?' . NEAR_FOUNDATION_PAGE_QUERY_PARAM . '=' . ($pageNumber - 1)); ?>"
                           class="relative inline-flex items-center px-4 py-1 text-xs border border-gray-300 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                        <?php endif; ?>
                        <?php if($scholarshipAppsReport->totalPage > 1 && $pageNumber < $scholarshipAppsReport->totalPage): ?>
                        <a href="<?php echo Helper::mergeQueryString($pageUrl, '?' . NEAR_FOUNDATION_PAGE_QUERY_PARAM . '=' . ($pageNumber + 1)); ?>"
                           class="ml-3 relative inline-flex items-center px-4 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                        <?php endif; ?>
                    </div>
                </nav>
                <?php } else { ?>
                <h3 class="py-5 sm:pl-3 sm:pr-5 text-center font-medium text-xl">No scholarship applications found
                </h3>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="detailsPopup" class="hidden fixed z-10 inset-0 overflow-y-auto details-popup">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-top bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6"
             role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                <button id="btnClose" type="button"
                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <!-- Heroicon name: x -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div>
                <div class="px-4 pb-3 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Scholarship Application
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Information about the scholarship application.
                    </p>
                </div>
                <div id="popUpMainContent" class="border-t border-gray-200 py-4 details-popup__main-content">
                    <div class="near-tab">
                        <div class="sm:hidden">
                            <label for="tabs" class="sr-only">Select a tab</label>
                            <select id="tabs" name="tabs"
                                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option selected>Personal</option>
                                <option>Bank &amp; Education</option>
                                <option>Family &amp; Siblings</option>
                                <option>Document &amp; Reference</option>
                            </select>
                        </div>
                        <div class="hidden sm:block">
                            <div class="border-b border-gray-200">
                                <nav class="near-tab__nav -mb-px flex space-x-8" aria-label="Tabs" id="mgtCenterTab">
                                    <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200" -->
                                    <a href="#" data-near-tab-content-id="personal"
                                       class="border-indigo-500 text-indigo-600 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm nav-link">
                                        Personal
                                    </a>
                                    <a href="#" data-near-tab-content-id="bank-and-education"
                                       class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm nav-link">
                                        Bank &amp; Education
                                    </a>

                                    <a href="#" data-near-tab-content-id="family-and-siblings"
                                       class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm nav-link"
                                       aria-current="page">
                                        Family &amp; Siblings
                                    </a>
                                    <a href="#" data-near-tab-content-id="document-and-reference"
                                       class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-200 whitespace-nowrap flex py-4 px-1 border-b-2 font-medium text-sm nav-link">
                                        Document &amp; Reference
                                    </a>
                                </nav>
                            </div>
                        </div>


                        <div class="px-3 py-5 near-tab__content-wrapper" id="mgtCenterTabContent">
                            <div class="near-tab__content near-tab__content--active" id="personal" role="tabpanel"
                                 aria-labelledby="personal-tab">
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Last Name
                                                    </dt>
                                                    <dd id="txt-lastName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        First Name
                                                    </dt>
                                                    <dd id="txt-firstName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Other Names
                                                    </dt>
                                                    <dd id="txt-otherNames" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        National ID Number
                                                    </dt>
                                                    <dd id="txt-nationalIdNumber" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Birth Place
                                                    </dt>
                                                    <dd id="txt-birthPlace" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Birth Date
                                                    </dt>
                                                    <dd id="txt-birthDate" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Email Address
                                                    </dt>
                                                    <dd id="txt-emailAddress" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Mobile Number
                                                    </dt>
                                                    <dd id="txt-mobileNumber" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Parent Number
                                                    </dt>
                                                    <dd id="txt-parentNumber" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Did you get scholarship from our foundation last year?
                                                    </dt>
                                                    <dd id="txt-gotScholarshipLastYear"
                                                        class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Type of scholarship required
                                                    </dt>
                                                    <dd id="txt-requiredScholarships"
                                                        class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        File ID
                                                    </dt>
                                                    <dd id="txt-fileId" class="mt-1 text-sm text-gray-900 break-all">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        State of Origin
                                                    </dt>
                                                    <dd id="txt-stateOfOrigin" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Address
                                                    </dt>
                                                    <dd id="txt-address" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        How did you know about our foundation?
                                                    </dt>
                                                    <dd id="txt-howKnowFoundation" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Do you want to participate in our foundation's activities as
                                                        a volunteer?
                                                    </dt>
                                                    <dd id="txt-volunteerInterest" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Why are you applying for the scholarship?
                                                    </dt>
                                                    <dd id="txt-whyScholarship" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Approved
                                                    </dt>
                                                    <dd id="txt-approved" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Testified the information provided is correct
                                                    </dt>
                                                    <dd id="txt-iAgree" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Applied On
                                                    </dt>
                                                    <dd id="txt-insertDate" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="near-tab__content" id="bank-and-education" role="tabpanel"
                                 aria-labelledby="bank-and-education-tab">
                                <h3 class="font-bold text-gray-700 text-sm mb-2">Bank</h3>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Bank Name
                                                    </dt>
                                                    <dd id="txt-bankName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Bank Branch
                                                    </dt>
                                                    <dd id="txt-branchName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Account Number
                                                    </dt>
                                                    <dd id="txt-accountNumber" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        IBAN
                                                    </dt>
                                                    <dd id="txt-ibanNumber" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-700 text-sm mb-2 mt-4">Education</h3>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        School
                                                    </dt>
                                                    <dd id="txt-schoolName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Level
                                                    </dt>
                                                    <dd id="txt-level" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Department
                                                    </dt>
                                                    <dd id="txt-department" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Class
                                                    </dt>
                                                    <dd id="txt-class" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        City
                                                    </dt>
                                                    <dd id="txt-city" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        State
                                                    </dt>
                                                    <dd id="txt-state" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="near-tab__content" id="family-and-siblings" role="tabpanel"
                                 aria-labelledby="family-and-siblings-tab">
                                <h3 class="font-bold text-gray-700 text-sm mb-2 mt-4">Father</h3>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Name
                                                    </dt>
                                                    <dd id="txt-fatherName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Alive or Deceased
                                                    </dt>
                                                    <dd id="txt-fatherAliveOrDeceased"
                                                        class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Occupation
                                                    </dt>
                                                    <dd id="txt-fatherOccupation" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Monthly Income
                                                    </dt>
                                                    <dd id="txt-fatherMonthlyIncome" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        City
                                                    </dt>
                                                    <dd id="txt-fatherCity" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        State
                                                    </dt>
                                                    <dd id="txt-fatherState" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Mobile Number
                                                    </dt>
                                                    <dd id="txt-fatherMobileNumber" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-700 text-sm mb-2 mt-4">Mother</h3>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Name
                                                    </dt>
                                                    <dd id="txt-motherName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Alive or Deceased
                                                    </dt>
                                                    <dd id="txt-motherAliveOrDeceased"
                                                        class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Occupation
                                                    </dt>
                                                    <dd id="txt-motherOccupation" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Monthly Income
                                                    </dt>
                                                    <dd id="txt-motherMonthlyIncome" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        City
                                                    </dt>
                                                    <dd id="txt-motherCity" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        State
                                                    </dt>
                                                    <dd id="txt-motherState" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Mobile Number
                                                    </dt>
                                                    <dd id="txt-motherMobileNumber" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-700 text-sm mb-2 mt-4">Siblings</h3>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        No. of siblings
                                                    </dt>
                                                    <dd id="txt-nSiblings" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        No. of siblings in primary
                                                    </dt>
                                                    <dd id="txt-nSiblingsInPrimary" class="mt-1 text-sm text-gray-900">
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        No. of siblings in secondary
                                                    </dt>
                                                    <dd id="txt-nSiblingsInSecondary"
                                                        class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        No. of siblings in university
                                                    </dt>
                                                    <dd id="txt-nSiblingsInUniversity"
                                                        class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="near-tab__content" id="document-and-reference" role="tabpanel"
                                 aria-labelledby="document-and-reference-tab">
                                <h3 class="font-bold text-gray-700 text-sm mb-2 mt-4">Document</h3>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Passport photograph
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docPassportPhotograph" href="#" target="_blank">Click
                                                            to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Request letter
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docRequestLetter" href="#" target="_blank">Click to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Admission letter
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docAdmissionLetter" href="#" target="_blank">Click to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        JAMB result
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docJambResult" href="#" target="_blank">Click to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        WAEC result
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docWaecResult" href="#" target="_blank">Click to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Matriculation number
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docMatriculationNumber" href="#"
                                                           target="_blank">Click to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Indigene certificate
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docIndigeneCertificate" href="#"
                                                           target="_blank">Click to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Birth certificate
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docBirthCertificate" href="#" target="_blank">Click
                                                            to
                                                            view</a>
                                                    </dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Valid ID card
                                                    </dt>
                                                    <dd class="mt-1 text-sm text-gray-900 break-all">
                                                        <a id="txt-docValidIdCard" href="#" target="_blank">Click to
                                                            view</a>
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-700 text-sm mb-2 mt-4">Reference</h3>
                                <div class="flex flex-col">
                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Last name
                                                    </dt>
                                                    <dd id="txt-refLastName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        First name
                                                    </dt>
                                                    <dd id="txt-refFirstName" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Other names
                                                    </dt>
                                                    <dd id="txt-refOtherNames" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Occupation
                                                    </dt>
                                                    <dd id="txt-refOccupation" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Position
                                                    </dt>
                                                    <dd id="txt-refPosition" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Address
                                                    </dt>
                                                    <dd id="txt-refAddress" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                                <div class="sm:col-span-1">
                                                    <dt class="text-sm font-medium text-gray-500">
                                                        Phone number
                                                    </dt>
                                                    <dd id="txt-refPhoneNumber" class="mt-1 text-sm text-gray-900"></dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
