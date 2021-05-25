<div id="donationWrapper" class="mx-auto col-md-5 c-donation-form">
    <form id="donationForm" class="c-donation-form__instance" data-parsley-focus="none"
          data-parsley-errors-messages-disabled>
        <div class="py-4 c-scholarship-form__header">
            <h2>Donate today</h2>
            <p class="lead c-scholarship-form__info">
                Your donation help put children through school and make our communities safer to live in.
            </p>
        </div>
        <div id="donation-form-notification" class="alert alert-dismissible fade d-none" role="alert">
            <div class="alert-message"></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="form-group">
            <label for="txtEmail">Email</label>
            <input type="email" class="form-control" id="txtEmail" name="donation[txtEmail]"
                   placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="ddlAmount">Amount to give</label>
            <select class="custom-select d-block w-100" id="ddlAmount" name="donation[ddlAmount]" required>
                <option value="">Choose...</option>
                <option value="5000">NGN 5,000</option>
                <option value="10000">NGN 10,000</option>
                <option value="30000">NGN 30,000</option>
                <option value="50000">NGN 50,000</option>
                <option value="100000">NGN 100,000</option>
                <option value="other">Other amount</option>
            </select>
        </div>
        <div class="form-group d-none" id="otherAmountWrapper">
            <label for="txtOtherAmount">Other Amount</label>
            <input type="text" class="form-control" id="txtOtherAmount" name="donation[txtOtherAmount]"
                   placeholder="Amount" data-parsley-type="number" data-parsley-validate-if-empty
                   data-parsley-require-if="#ddlAmount">
        </div>
        <div class="form-group">
            <label for="ddlReason">Reason</label>
            <select class="custom-select d-block w-100" id="ddlReason" name="donation[ddlReason]" required>
                <option value="">Choose...</option>
                <option value="Education Relief">Education Relief</option>
                <option value="Health Relief">Health Relief</option>
                <option value="Hunger Relief">Hunger Relief</option>
                <option value="Water Relief">Water Relief</option>
                <option value="General Donation">General Donation</option>
            </select>
        </div>
        <div class="form-group">
            <label for="txtDonationNarration">Narration</label>
            <input type="text" class="form-control" id="txtDonationNarration" name="donation[txtDonationNarration]">
        </div>
        <button id="btnDonate" type="button" class="mb-2 btn btn-outline-primary btn-block btn-lg">Donate</button>
    </form>
</div>
