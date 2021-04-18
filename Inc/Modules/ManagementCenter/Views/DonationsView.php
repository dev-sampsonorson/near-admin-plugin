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
    
    $donationReport = $reportRepo->getDonationReport($searchTerm, $pageNumber, NEAR_FOUNDATION_DEFAULT_PAGE_SIZE);
?>

<div class="text-gray-500" id="management-center-wrapper">
    <div class="mt-6 sm:px-1">
        <h3 class="text-lg font-medium">Donations</h3>
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
                               placeholder="Email or Amount" aria-describedby="live-search-desc">
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
                <?php if (count($donationReport->result) > 0) { ?>
                <div class="inline-block min-w-full py-2 align-middle sm:pl-3 sm:pr-5">
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table id="tblRecords" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Amount
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Reason
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Narration
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Donated On
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">View</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach($donationReport->result as $row) { ?>
                                <tr data-record-id="<?php echo $row->getId(); ?>" class="align-top">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        <?php echo Helper::toNaira($row->amount); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <?php echo $row->emailAddress; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <?php echo $row->reason; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <?php echo $row->narration; ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <?php echo Helper::timeAgo($row->getInsertDate()); ?></td>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <a id="<?php echo "view-" . $row->getId(); ?>"
                                           data-record-id="<?php echo $row->getId(); ?>" data-record-type="donation"
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
                        <span class="font-medium"><?php echo $donationReport->startRecord; ?></span>
                        to
                        <span class="font-medium"><?php echo $donationReport->endRecord; ?></span>
                        of
                        <span class="font-medium"><?php echo $donationReport->recordTotal; ?></span>
                        results
                    </div>
                    <div class="flex justify-between flex-1 sm:justify-end">
                        <?php if($pageNumber > 1): ?>
                        <a href="<?php echo Helper::mergeQueryString($pageUrl, '?' . NEAR_FOUNDATION_PAGE_QUERY_PARAM . '=' . ($pageNumber - 1)); ?>"
                           class="relative inline-flex items-center px-4 py-1 text-xs border border-gray-300 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                        <?php endif; ?>
                        <?php if($donationReport->totalPage > 1 && $pageNumber < $donationReport->totalPage): ?>
                        <a href="<?php echo Helper::mergeQueryString($pageUrl, '?' . NEAR_FOUNDATION_PAGE_QUERY_PARAM . '=' . ($pageNumber + 1)); ?>"
                           class="ml-3 relative inline-flex items-center px-4 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                        <?php endif; ?>
                    </div>
                </nav>
                <?php } else { ?>
                <h3 class="py-5 sm:pl-3 sm:pr-5 text-center font-medium text-xl">No donations found
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
                        Donation
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Information about donation.
                    </p>
                </div>
                <div id="popUpMainContent"
                     class="border-t border-gray-200 px-3 py-4 sm:px-5 details-popup__main-content">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Email Address
                            </dt>
                            <dd id="txt-emailAddress" class="mt-1 text-sm text-gray-900"></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Amount Dontated
                            </dt>
                            <dd id="txt-amount" class="mt-1 text-sm text-gray-900"></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Reason
                            </dt>
                            <dd id="txt-reason" class="mt-1 text-sm text-gray-900"></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Narration
                            </dt>
                            <dd id="txt-narration" class="mt-1 text-sm text-gray-900"></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">
                                Date Donated
                            </dt>
                            <dd id="txt-insertDate" class="mt-1 text-sm text-gray-900"></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
