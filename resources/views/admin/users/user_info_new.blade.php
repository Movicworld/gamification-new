@extends('layouts.main.master')

@section('content')
    <div class="content">

        @php
            $userCurr = $info->currency_code;
            $activeBal = $info->active_balance;
            $isVerified = $info->isVerifiedInCurrency();
            $currParam = \App\Models\Currency::where('code', $userCurr)->first();
        @endphp

        <!-- User Header Profile Card -->
        <div class="block block-rounded">
            <div class="block-content text-center py-4">
                <div class="mb-3 position-relative d-inline-block">
                    <div class="avatar avatar-96 rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto text-primary fw-bold fs-1 shadow-sm" style="width: 90px; height: 90px;">
                        {{ strtoupper(substr($info->name, 0, 1)) }}
                    </div>
                    @if($isVerified)
                        <span class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1" style="width: 26px; height: 26px; display: flex; align-items: center; justify-content: center;" title="Verified Account">
                            <i class="fa fa-check fs-xs"></i>
                        </span>
                    @endif
                </div>

                <h1 class="fs-4 fw-bold mb-1">
                    {{ $info->name }}
                    @if($info->is_celebrity)
                        <span class="badge bg-warning text-dark fs-xs align-middle ms-1">Celebrity</span>
                    @endif
                    @if($info->is_business)
                        <span class="badge bg-primary text-white fs-xs align-middle ms-1">Business</span>
                    @endif
                </h1>

                <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap mb-2">
                    <span class="badge-currency badge-currency-{{ strtolower($userCurr) }} fs-sm py-1 px-2">
                        <i class="fa fa-circle fs-xs"></i> {{ $userCurr }} Account
                    </span>
                    <span class="text-muted fs-sm">&#8226;</span>
                    <span class="text-muted fs-sm">{{ $info->email }}</span>
                    <span class="text-muted fs-sm">&#8226;</span>
                    <span class="text-muted fs-sm">{{ $info->phone ?? 'No phone' }}</span>
                    @if($info->country)
                        <span class="text-muted fs-sm">&#8226;</span>
                        <span class="badge bg-secondary-light text-dark fs-xs">{{ $info->country }}</span>
                    @endif
                </div>

                <div class="text-muted fs-xs">
                    Member since {{ \Carbon\Carbon::parse($info->created_at)->format('M d, Y') }} ({{ \Carbon\Carbon::parse($info->created_at)->diffForHumans() }})
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="block-content bg-body-light border-top">
                <div class="row text-center py-2">
                    <div class="col-6 col-md-3 border-end">
                        <div class="fs-xs fw-semibold text-uppercase text-muted mb-1">Active Balance</div>
                        <div class="fs-3 fw-bold {{ $activeBal > 0 ? 'text-success' : 'text-dark' }}">
                            {{ formatCurrency($activeBal, $userCurr) }}
                        </div>
                        <div class="fs-xs text-muted">
                            <a href="{{ url('admin/user/transactions/' . $info->id) }}" target="_blank" class="text-primary">View Ledger <i class="fa fa-arrow-right fs-xs"></i></a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 border-end">
                        <div class="fs-xs fw-semibold text-uppercase text-muted mb-1">Campaigns</div>
                        <div class="fs-3 fw-bold text-dark">{{ number_format($info->my_campaigns_count) }}</div>
                        <div class="fs-xs text-muted">
                            <a href="{{ url('admin/user/campaigns/' . $info->id) }}" target="_blank" class="text-primary">Campaigns</a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 border-end">
                        <div class="fs-xs fw-semibold text-uppercase text-muted mb-1">Jobs Attempted</div>
                        <div class="fs-3 fw-bold text-dark">{{ number_format($info->my_jobs_count) }}</div>
                        <div class="fs-xs text-muted">
                            <a href="{{ url('admin/user/jobs/' . $info->id) }}" target="_blank" class="text-primary">User Jobs</a>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="fs-xs fw-semibold text-uppercase text-muted mb-1">Referrals</div>
                        <div class="fs-3 fw-bold text-dark">{{ number_format($info->referees_count) }}</div>
                        <div class="fs-xs text-muted">
                            <a href="{{ url('admin/user/referral/' . $info->id) }}" target="_blank" class="text-primary">Referral Tree</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
                <i class="fa fa-check-circle me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center shadow-sm" role="alert">
                <i class="fa fa-exclamation-circle me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info d-flex align-items-center shadow-sm" role="alert">
                <i class="fa fa-info-circle me-2 fs-5"></i>
                <div>{{ session('info') }}</div>
            </div>
        @endif

        <!-- Account Info Summary Cards -->
        <div class="row">
            <div class="col-lg-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title fs-sm fw-bold text-uppercase">Profile & Status Information</h3>
                    </div>
                    <div class="block-content fs-sm">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted fw-medium" style="width: 45%;">Account Verification</td>
                                    <td>
                                        @if($isVerified)
                                            <span class="badge bg-success-light text-success"><i class="fa fa-check me-1"></i> Verified in {{ $userCurr }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white">Unverified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-medium">Referral Code</td>
                                    <td><span class="font-monospace fw-bold">{{ $info->referral_code ?? 'None' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-medium">Referred By</td>
                                    <td>{{ $referredBy ? $referredBy->name . ' (' . $referredBy->email . ')' : 'Direct Registration' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-medium">Email Status</td>
                                    <td>
                                        @if($info->email_verified_at)
                                            <span class="text-success"><i class="fa fa-check-circle me-1"></i> Verified</span>
                                        @else
                                            <span class="text-warning"><i class="fa fa-clock me-1"></i> Pending Verification</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-medium">Blacklisted / Banned</td>
                                    <td>
                                        @if($info->is_blacklisted)
                                            <span class="badge bg-danger">Banned / Blacklisted</span>
                                        @else
                                            <span class="badge bg-success-light text-success">Good Standing</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-medium">Auth Device / Source</td>
                                    <td>{{ ucfirst($info->auth_device ?? 'Web') }} &#8226; {{ $info->source ?? 'organic' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title fs-sm fw-bold text-uppercase">Banking & Payout Channels</h3>
                    </div>
                    <div class="block-content fs-sm">
                        @if($info->accountDetails && $info->accountDetails->account_number)
                            <div class="mb-3 p-3 bg-light rounded">
                                <div class="fw-bold text-dark mb-1"><i class="fa fa-university me-1 text-primary"></i> Payout Bank Account</div>
                                <div><strong>Name:</strong> {{ $info->accountDetails->name }}</div>
                                <div><strong>Bank:</strong> {{ $info->accountDetails->bank_name }}</div>
                                <div><strong>Account Number:</strong> <span class="font-monospace fw-bold">{{ $info->accountDetails->account_number }}</span></div>
                            </div>
                        @else
                            <div class="mb-3 p-3 bg-light rounded text-muted">
                                <i class="fa fa-info-circle me-1"></i> No payout bank account details on file.
                            </div>
                        @endif

                        @if($info->virtualAccount)
                            <div class="p-3 bg-light rounded">
                                <div class="fw-bold text-dark mb-1"><i class="fa fa-credit-card me-1 text-success"></i> Freebyz Dedicated Virtual Account</div>
                                <div><strong>Bank:</strong> {{ $info->virtualAccount->bank_name }}</div>
                                <div><strong>Account Name:</strong> {{ $info->virtualAccount->account_name }}</div>
                                <div><strong>Account Number:</strong> <span class="font-monospace fw-bold">{{ $info->virtualAccount->account_number }}</span></div>
                            </div>
                        @elseif($userCurr === 'NGN')
                            <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between">
                                <span class="text-muted">Virtual account not generated yet.</span>
                                <a href="{{ url('reactivate/virtual/account/' . $info->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fa fa-plus me-1"></i> Generate NGN Virtual Account
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Management Actions Tabs -->
        <div class="block block-rounded">
            <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="tab-topup-btn" data-bs-toggle="tab" data-bs-target="#tab-topup" role="tab">
                        <i class="fa fa-wallet me-1 text-primary"></i> Wallet Topup & Debit
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-verification-btn" data-bs-toggle="tab" data-bs-target="#tab-verification" role="tab">
                        <i class="fa fa-check-double me-1 text-success"></i> Verification
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-switch-btn" data-bs-toggle="tab" data-bs-target="#tab-switch" role="tab">
                        <i class="fa fa-exchange-alt me-1 text-warning"></i> Switch Currency
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-bank-btn" data-bs-toggle="tab" data-bs-target="#tab-bank" role="tab">
                        <i class="fa fa-university me-1 text-info"></i> Bank Details
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-more-btn" data-bs-toggle="tab" data-bs-target="#tab-more" role="tab">
                        <i class="fa fa-cog me-1 text-muted"></i> Account Controls
                    </button>
                </li>
            </ul>

            <div class="block-content tab-content py-4">

                <!-- 1. WALLET TOPUP / DEBIT TAB -->
                <div class="tab-pane fade show active" id="tab-topup" role="tabpanel">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="mb-4 text-center">
                                <h4 class="fw-bold mb-1">Credit or Debit User Wallet</h4>
                                <p class="text-muted fs-sm">
                                    Current Active Balance: <strong>{{ formatCurrency($activeBal, $userCurr) }}</strong> ({{ $userCurr }})
                                </p>
                            </div>

                            <form action="{{ route('admin.wallet.topup') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $info->id }}">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Action Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-select" required>
                                            <option value="credit">Credit User (Add Funds)</option>
                                            <option value="debit">Debit User (Deduct Funds)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                                        <select name="currency" class="form-select" required>
                                            <option value="{{ $userCurr }}" selected>{{ $userCurr }} (User Base Currency)</option>
                                            @if(isset($activeCurrencies))
                                                @foreach($activeCurrencies as $cur)
                                                    @if($cur->code !== $userCurr)
                                                        <option value="{{ $cur->code }}">{{ $cur->code }} - {{ $cur->country }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text fw-bold">{{ currencySymbol($userCurr) }}</span>
                                            <input type="number" step="0.01" min="0.01" class="form-control" name="amount" placeholder="0.00" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold">Reason / Description <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reason" placeholder="e.g. Administrative refund, dispute resolution, bonus..." required>
                                    </div>

                                    <div class="col-md-12 text-center pt-2">
                                        <button type="submit" class="btn btn-primary px-4 py-2" onclick="return confirm('Are you sure you want to process this wallet adjustment?')">
                                            <i class="fa fa-check me-1"></i> Process Transaction
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. VERIFICATION TAB -->
                <div class="tab-pane fade" id="tab-verification" role="tabpanel">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center py-3">
                            <div class="avatar avatar-64 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center {{ $isVerified ? 'bg-success-light text-success' : 'bg-warning-light text-warning' }}" style="width: 64px; height: 64px;">
                                <i class="fa {{ $isVerified ? 'fa-user-check' : 'fa-user-clock' }} fs-2"></i>
                            </div>

                            <h4 class="fw-bold mb-1">
                                {{ $isVerified ? 'Account is Currently Verified' : 'Account is Unverified' }}
                            </h4>
                            <p class="text-muted fs-sm mb-4">
                                Current Base Currency: <strong>{{ $userCurr }}</strong> &bull;
                                Standard Fee: <strong>{{ formatCurrency($currParam->upgrade_fee ?? 0, $userCurr) }}</strong> &bull;
                                Referral Commission: <strong>{{ formatCurrency($currParam->referral_commission ?? 0, $userCurr) }}</strong>
                            </p>

                            <div class="d-flex justify-content-center gap-3">
                                @if($isVerified)
                                    <a href="{{ route('admin.user.upgrade', $info->id) }}" 
                                       class="btn btn-warning px-4 py-2"
                                       onclick="return confirm('Are you sure you want to UNVERIFY this user? They will lose verified privileges.')">
                                        <i class="fa fa-times-circle me-1"></i> Unverify User Now
                                    </a>
                                @else
                                    <a href="{{ route('admin.user.upgrade', $info->id) }}" 
                                       class="btn btn-success px-4 py-2"
                                       onclick="return confirm('Verify user {{ $info->name }} in {{ $userCurr }}? Referral bonus will be disbursed.')">
                                        <i class="fa fa-check-circle me-1"></i> Verify User ({{ $userCurr }}) Now
                                    </a>
                                @endif
                            </div>

                            @if($userCurr === 'NGN')
                                <hr class="my-4">
                                <div class="text-center">
                                    <h5 class="fs-sm fw-bold text-muted text-uppercase mb-2">Dedicated Virtual Account (Wema/Monnify)</h5>
                                    <a href="{{ url('reactivate/virtual/account/' . $info->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-sync me-1"></i> Generate / Regenerate Virtual Account
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 3. SMART CURRENCY SWITCHER TAB -->
                <div class="tab-pane fade" id="tab-switch" role="tabpanel">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1">Single-Currency Base Switcher</h4>
                                <p class="text-muted fs-sm">
                                    Convert user's account and active balance from <strong>{{ $userCurr }}</strong> to a new supported currency.
                                </p>
                            </div>

                            <div class="card border-0 bg-light p-3 mb-4 rounded-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fs-xs text-muted text-uppercase fw-bold">Current Currency:</span>
                                        <div class="fs-5 fw-bold text-dark">
                                            <span class="badge-currency badge-currency-{{ strtolower($userCurr) }}">{{ $userCurr }}</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="fs-xs text-muted text-uppercase fw-bold">Current Live Balance:</span>
                                        <div class="fs-5 fw-bold text-success">{{ formatCurrency($activeBal, $userCurr) }}</div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ url('admin/switch/wallet') }}" method="POST" id="currencySwitchForm">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $info->id }}">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Select New Target Currency <span class="text-danger">*</span></label>
                                    <select name="currency" id="targetCurrencySelect" class="form-select form-select-lg" required>
                                        <option value="">-- Choose New Currency --</option>
                                        @if(isset($activeCurrencies))
                                            @foreach($activeCurrencies as $curr)
                                                @if($curr->code !== $userCurr)
                                                    <option value="{{ $curr->code }}" data-rate="{{ $curr->base_rate }}">
                                                        {{ $curr->code }} - {{ $curr->country }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Conversion Alert & Explanation -->
                                <div class="alert alert-info border-0 shadow-none fs-sm">
                                    <i class="fa fa-info-circle me-1"></i>
                                    <strong>Automatic Balance Conversion:</strong>
                                    Switching will convert the user's active balance ({{ formatCurrency($activeBal, $userCurr) }}) to the new currency using current live exchange rates, update both <code>wallets.base_currency</code> and <code>users.base_currency</code>, zero out the old column, and log an audit transaction.
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-4 py-2" onclick="return confirm('Are you sure you want to switch this user currency? Their active balance will be automatically converted.')">
                                        <i class="fa fa-exchange-alt me-1"></i> Convert & Switch Currency
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 4. BANK DETAILS TAB -->
                <div class="tab-pane fade" id="tab-bank" role="tabpanel">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-4">
                                <h4 class="fw-bold mb-1">Update Payout Bank Account</h4>
                                <p class="text-muted fs-sm">Resolves account name automatically with Paystack bank lookup</p>
                            </div>

                            <form action="{{ route('admin.update.account.details') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $info->id }}">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Bank Name <span class="text-danger">*</span></label>
                                    <select class="form-select" name="bank_code" required>
                                        <option value="">Select Bank</option>
                                        @foreach ($bankList as $bank)
                                            <option value="{{ $bank['code'] }}" {{ @$info->accountDetails->bank_code == $bank['code'] ? 'selected' : '' }}>
                                                {{ $bank['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Account Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control font-monospace" name="account_number"
                                        placeholder="10-digit NGN Account Number" required value="{{ @$info->accountDetails->account_number }}">
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="fa fa-save me-1"></i> Save Account Details
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 5. ACCOUNT CONTROLS TAB -->
                <div class="tab-pane fade" id="tab-more" role="tabpanel">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <!-- Celebrity Toggle -->
                            <div class="card border p-3 mb-4 rounded-3">
                                <h5 class="fw-bold mb-1">Celebrity / Influencer Status</h5>
                                <p class="text-muted fs-sm mb-3">
                                    Celebrity accounts do not receive regular referral bonuses and receive a 10% discount on verification fees.
                                </p>
                                <form action="{{ route('admin.celebrity') }}" method="POST" class="row g-2 align-items-center">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $info->id }}">
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="referral_code" 
                                            value="{{ $info->referral_code }}" placeholder="Custom Celebrity Referral Code" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-outline-primary w-100">Set Celebrity Code</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Business Account Toggle -->
                            <div class="card border p-3 mb-4 rounded-3">
                                <h5 class="fw-bold mb-1">Business Account Toggle</h5>
                                <p class="text-muted fs-sm mb-3">Current Status: <strong>{{ $info->is_business ? 'Business Account' : 'Regular User' }}</strong></p>
                                <form action="{{ route('admin.toggle.business') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $info->id }}">
                                    <button type="submit" class="btn btn-outline-info">
                                        <i class="fa fa-briefcase me-1"></i> Toggle Business Account Mode
                                    </button>
                                </form>
                            </div>

                            <!-- Blacklist / Ban -->
                            <div class="card border border-danger-subtle p-3 rounded-3 bg-danger-light">
                                <h5 class="fw-bold text-danger mb-1">Account Suspension</h5>
                                <p class="text-muted fs-sm mb-3">Suspending an account revokes access to payouts, tasks, and referrals.</p>
                                @if(!$info->is_blacklisted)
                                    <a class="btn btn-danger" href="{{ url('admin/blacklist/' . $info->id) }}"
                                       onclick="return confirm('Are you sure you want to BLACKLIST this user?')">
                                        <i class="fa fa-ban me-1"></i> Blacklist / Suspend User
                                    </a>
                                @else
                                    <span class="badge bg-danger py-2 px-3 fs-sm"><i class="fa fa-ban me-1"></i> Account is Currently Blacklisted</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
