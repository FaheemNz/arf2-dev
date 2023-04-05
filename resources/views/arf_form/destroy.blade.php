@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('arfform.destroy') }}" method="POST">
        @csrf
        
        <input type="hidden" value="{{ $arf->id }}" name="arf_id" />
        <div class="row justify-content-center">
            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-xl-7 col-lg-10">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Offboarding ARF Form</li>
                    </ol>
                </nav>

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p>ARF Offboarding has been submitted.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div id="arf-form-container">
                    <!-- Section 1 -->
                    <div id="arf-form-header" class="table-responsive">
                        <table class="table table-sm table-bordered m-0 p-0">
                            <tbody>
                                <tr class="d-flex align-items-center p-0">
                                    <td class="col-3 col-xs-0 d-xs-none">
                                        <img src="{{ asset('images/Azizi_Logo.png') }}" height="136" width="180" alt="">
                                    </td>
                                    <td class="col-5 text-center border-0">
                                        <div class="arf-heading-lg">it asset release form [arf]</div>
                                    </td>
                                    <td class="col-4">
                                        <table class="table table-sm m-0 table-striped table-bordered" id="arf-header-table">
                                            <tbody class="">
                                                <tr>
                                                    <td class="arf-heading-md">Date: </td>
                                                    <td>
                                                        <input class="form-control arf-form-control" type="date" name="arf_date" 
                                                            value="{{ date('Y-m-d', strtotime($arf->created_at)) }}" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="arf-heading-md col-1">Dept: </td>
                                                    <td>
                                                        <select disabled onchange="preSelectOfficeLocation(this.value)" name="arf_dept" id="arf_dept" class="form-select form-select-sm" aria-label="Default" required>
                                                            <option selected value="{{ $arf->department->id }}">{{ $arf->department->name }}</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="arf-heading-md">Office_Loc:</td>
                                                    <td>
                                                        <select disabled id="arf_office_location" name="arf_office_location" required class="form-select form-select-sm">
                                                            <option selected value="{{ $arf->officeLocation->id }}">{{ $arf->officeLocation->name }}</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="arf-heading-md">Emp ID: </td>
                                                    <td>
                                                        <div>
                                                            <input class="form-control arf-form-control" type="number" name="arf_emp_id" required value="{{ $arf->emp_id }}" readonly />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Section 2 -->
                    <div id="arf-section-2">
                        <table class="table table-bordered table-sm m-0">
                            <tbody>
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <td colspan="2" id="arf-section-2-heading">Staff Details</td>
                                        </tr>
                                        <tr>
                                            <td class="col-3 arf-heading-md">Name</td>
                                            <td>
                                                <input class="form-control arf-form-control arf-form-control-section-2" type="text" id="arf-name" name="arf_name" required value="{{ $arf->name }}" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3 arf-heading-md">Contact Details</td>
                                            <td>
                                                <input value="{{ $arf->contact_details }}" class="form-control arf-form-control arf-form-control-section-2" type="text" name="arf_contact_details" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-3 arf-heading-md">Email ID</td>
                                            <td>
                                                <input class="form-control arf-form-control arf-form-control-section-2" type="text" id="arf-email" name="arf_email" required value="{{ $arf->email }}" readonly />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </tbody>
                        </table>
                    </div>

                    <!-- Section 3 -->
                    <div id="arf-section-3">
                        <table class="table table-bordered table-sm table-striped">
                            <thead class="text-uppercase text-center">
                                <th>s/n</th>
                                <th>items</th>
                                <th>asset_code</th>
                                <th>sno/brand</th>
                                <th>date_issued</th>
                                <th>remarks</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @if( count($arf->laptops) > 0 )
                                <tr id="laptop-row">
                                    <td>1</td>
                                    <td class="arf-heading-md">laptop</td>
                                    <td class="asset-code-input">
                                        <div class="d-flex align-items-center">
                                            <input required class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" disabled name="arf_laptop_asset_code" id="arf_laptop_asset_code" value="{{ $arf->laptops[0]->asset_code }}" readonly />
                                            <input type="hidden" name="arf_offboarding_laptop_id" value="{{ $arf->laptops[0]->id }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <select required name="arf_laptop_brand" class="form-select brand-input form-select-sm arf-form-control-section-2 arf-toggle-input" disabled id="arf_laptop_brand">
                                            <option value="">{{ $arf->laptops[0]->asset_brand }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required class="form-control arf-form-control date-issued arf-form-control-section-2 arf-toggle-input" type="date" disabled name="arf_laptop_date_issued" value="{{ date('Y-m-d', strtotime($arf->created_at)) }}" />
                                    </td>
                                    <td>
                                        <input required class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" disabled name="arf_laptop_remarks" value="{{ $arf->laptops[0]->remarks }}" />
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input name="has_laptop" id="has_laptop" value="Y" class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                </tr>
                                @endif

                                @if( count($arf->tablets) > 0 )
                                <tr id="tablet-row">
                                    <td>2</td>
                                    <td class="arf-heading-md">tablet</td>
                                    <td class="asset-code-input">
                                        <div class="d-flex align-items-center">
                                            <input readonly required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_tablet_asset_code" id="arf_tablet_asset_code" value="{{ $arf->tablets[0]->asset_code }}" />
                                            <input type="hidden" name="arf_offboarding_tablet_id" value="{{ $arf->tablets[0]->id }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <select required name="arf_tablet_brand" id="arf_tablet_brand" class="brand-input form-select form-select-sm arf-form-control-section-2 arf-toggle-input" disabled>
                                            <option value="{{ $arf->tablets[0]->asset_brand }}">{{ $arf->tablets[0]->asset_brand }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control date-issued arf-form-control-section-2 arf-toggle-input" type="date" name="arf_tablet_date_issued" value="{{ date('Y-m-d', strtotime($arf->created_at)) }}" />
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_tablet_remarks" value="{{ $arf->laptops[0]->remarks }}" />
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input name="has_tablet" id="has_tablet" value="Y" class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                </tr>
                                @endif

                                @if( count($arf->sims) > 0 )
                                <tr id="tablet-row">
                                    <td>2</td>
                                    <td class="arf-heading-md">sim</td>
                                    <td class="asset-code-input">
                                        <div class="d-flex align-items-center">
                                            <input readonly required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_sim_asset_code" id="arf_sim_asset_code" value="{{ $arf->sims[0]->asset_code }}" />
                                            <input type="hidden" name="arf_offboarding_sim_id" value="{{ $arf->sims[0]->id }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <select required name="arf_sim_brand" id="arf_sim_brand" class="brand-input form-select form-select-sm arf-form-control-section-2 arf-toggle-input" disabled>
                                            <option value="{{ $arf->sims[0]->asset_brand }}">{{ $arf->sims[0]->asset_brand }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control date-issued arf-form-control-section-2 arf-toggle-input" type="date" name="arf_sim_date_issued" value="{{ date('Y-m-d', strtotime($arf->created_at)) }}" />
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_sim_remarks" value="{{ $arf->laptops[0]->remarks }}" />
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input name="has_sim" id="has_sim" value="Y" class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                </tr>
                                @endif

                                @if( count($arf->desktops) > 0 )
                                <tr id="tablet-row">
                                    <td>2</td>
                                    <td class="arf-heading-md">desktop</td>
                                    <td class="asset-code-input">
                                        <div class="d-flex align-items-center">
                                            <input readonly required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_desktop_asset_code" id="arf_desktop_asset_code" value="{{ $arf->desktops[0]->asset_code }}" />
                                            <input type="hidden" name="arf_offboarding_desktop_id" value="{{ $arf->desktops[0]->id }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <select required name="arf_desktop_brand" id="arf_desktop_brand" class="brand-input form-select form-select-sm arf-form-control-section-2 arf-toggle-input" disabled>
                                            <option value="{{ $arf->desktops[0]->asset_brand }}">{{ $arf->desktops[0]->asset_brand }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control date-issued arf-form-control-section-2 arf-toggle-input" type="date" name="arf_desktop_date_issued" value="{{ date('Y-m-d', strtotime($arf->created_at)) }}" />
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_desktop_remarks" value="{{ $arf->laptops[0]->remarks }}" />
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input name="has_desktop" id="has_desktop" value="Y" class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                </tr>
                                @endif

                                @if( count($arf->monitors) > 0 )
                                <tr id="monitor-row">
                                    <td>2</td>
                                    <td class="arf-heading-md">monitor</td>
                                    <td class="asset-code-input">
                                        <div class="d-flex align-items-center">
                                            <input readonly required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_monitor_asset_code" id="arf_monitor_asset_code" value="{{ $arf->monitors[0]->asset_code }}" />
                                            <input type="hidden" name="arf_offboarding_monitor_id" value="{{ $arf->monitors[0]->id }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <select required name="arf_monitor_brand" id="arf_monitor_brand" class="brand-input form-select form-select-sm arf-form-control-section-2 arf-toggle-input" disabled>
                                            <option value="{{ $arf->monitors[0]->asset_brand }}">{{ $arf->monitors[0]->asset_brand }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control date-issued arf-form-control-section-2 arf-toggle-input" type="date" name="arf_monitor_date_issued" value="{{ date('Y-m-d', strtotime($arf->created_at)) }}" />
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_monitor_remarks" value="{{ $arf->laptops[0]->remarks }}" />
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input name="has_monitor" id="has_monitor" value="Y" class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                </tr>
                                @endif

                                @if( count($arf->mobiles) > 0 )
                                <tr id="mobile-row">
                                    <td>2</td>
                                    <td class="arf-heading-md">mobile</td>
                                    <td class="asset-code-input">
                                        <div class="d-flex align-items-center">
                                            <input readonly required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_mobile_asset_code" id="arf_mobile_asset_code" value="{{ $arf->mobiles[0]->asset_code }}" />
                                            <input type="hidden" name="arf_offboarding_mobile_id" value="{{ $arf->mobiles[0]->id }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <select required name="arf_mobile_brand" id="arf_mobile_brand" class="brand-input form-select form-select-sm arf-form-control-section-2 arf-toggle-input" disabled>
                                            <option value="{{ $arf->mobiles[0]->asset_brand }}">{{ $arf->mobiles[0]->asset_brand }}</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control date-issued arf-form-control-section-2 arf-toggle-input" type="date" name="arf_mobile_date_issued" value="{{ date('Y-m-d', strtotime($arf->created_at)) }}" />
                                    </td>
                                    <td>
                                        <input required disabled class="form-control arf-form-control arf-form-control-section-2 arf-toggle-input" type="text" name="arf_mobile_remarks" value="{{ $arf->laptops[0]->remarks }}" />
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input name="has_mobile" id="has_mobile" value="Y" class="form-check-input" type="checkbox" />
                                        </div>
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <!-- Section 4 -->
                    <div id="arf-section-4" class="text-center">
                        <div>
                            I <strong><u id="signature-name">{{ $arf->name }}</u></strong> acknowledge that I have received the above mentioned Asset / Assets.
                            I understand that these assets belong to AZIZI Developments and it's under my possession for carrying out my office work.I hereby assure you that I will take care of above Assets of the company to my best possible extent.
                        </div>
                    </div>

                    <!-- Section 5 -->
                    <div id="arf-section-5" class="text-center">
                        <strong>For HR Purpose:</strong> Any above Asset / Assets Lost or Damaged or Not Return to AZIZI at the time of end of service,
                        <strong>HR DEPARTMENT</strong> will deduct the value of above assets from final salary.
                    </div>

                    <div class="text-center mt-4">
                        <span>Registered Office: </span> PO Box 121385 Conrad, Dubai, United Arab Emirates
                    </div>
                </div>
                <div class="text-end mt-3">
                    <a href="/" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Initiate Offboarding
                    </button>
                </div>
                <div class="text-end mt-3 d-flex justify-content-end">
                    <div class="form-check">
                        <input checked class="form-check-input" type="checkbox" name="should_notify_user" value="1" id="should_notify_user">
                        <label class="form-check-label" for="should_notify_user">
                          Notify User
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection