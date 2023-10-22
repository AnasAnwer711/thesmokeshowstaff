<!-- Sidebar filter section -->
<section id="sidebar" class="py-5">
    <!-- <p> Home | <b>Find Staff</b></p> -->
    <div class="border-bottom pb-2 ml-2">
        <h4 id="burgundy">Filters</h4>
    </div>
    <div class="search-fields p-2" style="height:100vh;overflow:auto">
        <form action="{{ route('find-staff') }}" method="GET">
            <div class="py-3">
                <div class="set-notification p-2 ">
                    <h6 class="text-white mb-0">Search</h6>
                </div>
                <div class="my-2">
                    <input type="text" placeholder="Name" name="name" class="form-control mb-2"
                        value="{{ request()->input('name') }}">
                    <select class="form-control mb-2" name="state_id">
                        <option value="">Region</option>
                        <option ng-repeat="state in states" ng-selected="state.id == selectedStateId"
                            ng-value="state.id">
                            [[state.name]] </option>
                    </select>
                    <select class="form-control mb-2" name="gender">
                        <option value="" selected>Gender </option>
                        <option value="male" @if(request()->input('gender') == 'male') ?? selected @endif >Male</option>
                        <option value="female" @if(request()->input('gender') == 'female') ?? selected @endif>Female
                        </option>
                    </select>
                    <select class="form-control mb-2" name="age">
                        <option value="">AGE</option>
                        <option value="18-30" @if(request()->input('age') == '18-30') ?? selected @endif >18-30</option>
                        <option value="31-40" @if(request()->input('age') == '31-40') ?? selected @endif>31-40</option>
                        <option value="41-50" @if(request()->input('age') == '41-50') ?? selected @endif >41-50</option>
                        <option value="51-60" @if(request()->input('age') == '51-60') ?? selected @endif>51-60</option>
                        <option value="61-70" @if(request()->input('age') == '61-70') ?? selected @endif >61-70</option>
                        <option value="Above 70" @if(request()->input('age') == 'Above 70') ?? selected @endif>Above 70
                        </option>
                    </select>
                    <select class="form-control mb-2" name="qualification">
                        <option>Qualification</option>
                        <option value="RSA" @if(request()->input('qualification') == 'RSA') ?? selected @endif>RSA
                        </option>
                        <option value="RCG" @if(request()->input('qualification') == 'RCG') ?? selected @endif>RCG
                        </option>
                        <option value="Security" @if(request()->input('qualification') == 'Security') ?? selected
                            @endif>Security</option>
                        <option value="Silver Service" @if(request()->input('qualification') == 'Silver Service') ??
                            selected @endif>Silver Service</option>
                    </select>
                </div>
            </div>
            <div class="py-3" ng-repeat="staff_category in staff_categories">
                <div class="set-notification p-2 ">
                    <h6 class="text-white mb-0">[[staff_category.title]]</h6>
                </div>

                <div class="demo--content demo--place-center" ng-repeat="sub_category in staff_category.sub_categories">
                    <label class="form-control-760  mt-3 mb-0 ">
                        <input type="checkbox" ng-checked="selectedSkill(sub_category.id)"
                            ng-click="setSkillValue(sub_category.id)" class="skill" />
                        [[sub_category.title]]
                    </label>

                </div>
            </div>
            <input type="hidden" id="skillvalues" name="skillvalues" value="">
            <div class="py-3 ">
                <div class="set-notification p-2 ">
                    <h6 class="text-white mb-0">EXTRAS</h6>
                </div>
                <div class="mt-3">

                    <select class="form-control mb-2" name="build_type_id">
                        <option value="">Build Type</option>
                        <option ng-repeat="bt in build_types" ng-value="bt.id">[[bt.name]]</option>
                    </select>

                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <button class="btn btn-sm" type="submit">
                    Search
                </button>
            </div>
        </form>
    </div>

</section>