<?php defined("APP_NAME") or exit("No direct access allowed."); ?>
<form method="get" id="searchForm" action="App/Search/search.php">
    <div class="row">
        <div class="col-md">
            <label>Developers</label>
            <select name="developer" class="form-control">
                <option value="all">-ALL-</option>
                <?php if($developers): ?>
                    <?php foreach($developers as $developer): ?>
                        <option value="<?php echo $developer["id"]; ?>" <?php if(isset($params['developer']) && $params["developer"] == $developer["id"]); ?>><?php echo $developer['first_name']; ?> <?php echo $developer['last_name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <hr/>
            <label>Skills</label>
            <br />
            <input type="checkbox" id="all-skills-chk-toggle" name="all-skills" value="1" <?php if(isset($params['all-skills'])) { ?> checked <?php } ?> /> ALL (toggle)
            <div id="skills-container">
                <?php if($skills): ?>
                    <?php foreach($skills as $skill): ?>
                        <input type="checkbox" name="skill[]" class="skill-chk" value="<?php echo $skill["id"]; ?>" <?php
                        if(isset($params["skill"]) && in_array($skill["id"], explode(",", $params["skill"]))) { ?> checked <?php } ?> /> <?php echo $skill['name']; ?> <br/>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md">
            <label>Proficiency</label>
            <select name="proficiency" class="form-control">
                <option value="all" <?php if(isset($params) && $params['proficiency'] == 'all') { ?> selected <?php } ?>>- ALL -</option>
                <option value="1" <?php if(isset($params) && $params['proficiency'] == '1') { ?> selected <?php } ?>>1</option>
                <option value="2" <?php if(isset($params) && $params['proficiency'] == '2') { ?> selected <?php } ?>>2</option>
                <option value="3" <?php if(isset($params) && $params['proficiency'] == '3') { ?> selected <?php } ?>>3</option>
                <option value="4" <?php if(isset($params) && $params['proficiency'] == '4') { ?> selected <?php } ?>>4</option>
                <option value="5" <?php if(isset($params) && $params['proficiency'] == '5') { ?> selected <?php } ?>>5</option>
                <option value="6" <?php if(isset($params) && $params['proficiency'] == '6') { ?> selected <?php } ?>>6</option>
                <option value="7" <?php if(isset($params) && $params['proficiency'] == '7') { ?> selected <?php } ?>>7</option>
                <option value="8" <?php if(isset($params) && $params['proficiency'] == '8') { ?> selected <?php } ?>>8</option>
                <option value="9" <?php if(isset($params) && $params['proficiency'] == '9') { ?> selected <?php } ?>>9</option>
                <option value="10" <?php if(isset($params) && $params['proficiency'] == '10') { ?> selected <?php } ?>>10</option>
            </select>
            <hr/>
            <label>Additional Filters (Optional)</label>
            <br />
            - Skills:
            <br />
            <small>This filter works when results are grouped by developers</small>
            <ul>
                <li><input type="radio" name="skills" value="inclusive" <?php if(isset($params['skills']) && $params['skills'] == 'inclusive') { ?> checked <?php } ?>> Include all of the selected skills (if any) <i class="btn btn-info btn-sm fas fa-info" data-toggle="tooltip" data-placement="top" title="This will return list of developer(s) that have ALL of the selected skills"></i></li>
                <li><input type="radio" name="skills" value="exclusive" <?php if(isset($params['skills']) && $params['skills'] == 'exclusive') { ?> checked <?php } ?>> Include at least one of the selected skills (if any)
                    <i class="btn btn-info btn-sm fa fa-info" data-toggle="tooltip" data-placement="top" title="This will return list of developer(s) that have AT LEAST ONE of the selected skills"></i></li>
            </ul>

            - Proficiency: <i class="btn btn-info btn-sm fa fa-info" data-toggle="tooltip" data-placement="top" title="Enter numbers between 1 and 10. All other numbers will be ignored. This filter OVERRIDES the Proficiency dropdown menu."></i>
            <ul>
                <li>
                    <input type="radio" name="proficiency_range" value="greater" <?php if(isset($params['proficiency_greater'])) { ?> checked <?php } ?> class="filter-rbtn" /> greater than <input type="text" name="proficiency_greater" size="2" maxlength="2" value="<?php echo (isset($params['proficiency_greater'])) ? $params['proficiency_greater'] : ''; ?>" class="filter-input" />
                </li>
                <li>
                    <input type="radio" name="proficiency_range" value="less" <?php if(isset($params['proficiency_less'])) { ?> checked <?php } ?> class="filter-rbtn" /> less than <input type="text" name="proficiency_less" size="2" maxlength="2" value="<?php echo (isset($params['proficiency_less'])) ? $params['proficiency_less'] : ''; ?>" class="filter-input" />
                </li>
                <li>
                    <input type="radio" name="proficiency_range" value="between" <?php if(isset($params['proficiency_from']) || isset($params['proficiency_to'])) { ?> checked <?php } ?> class="filter-rbtn" /> between <input type="text" name="proficiency_from" size="2" maxlength="2" value="<?php echo (isset($params['proficiency_from'])) ? $params['proficiency_from'] : ''; ?>" class="filter-input" /> and <input type="text" name="proficiency_to" size="2" maxlength="2" value="<?php echo (isset($params['proficiency_to'])) ? $params['proficiency_to'] : ''; ?>" class="filter-input" />
                </li>
            </ul>


        </div>
        <div class="col-md">
            <label>Group & Limit (Optional)</label>
            <br />
            - Group results by:
            <ul>
                <li><input type="radio" name="group_by" value="developers" class="filter-rbtn" <?php if(isset($params['group_by']) && $params['group_by'] == 'developers') { ?> checked <?php } ?> /> Developers <i class="btn btn-info btn-sm fa fa-info" data-toggle="tooltip" data-placement="top" title="Developers will be listed in the 1st column and list of their skills in the 2nd column."></i></li>
                <li><input type="radio" name="group_by" value="skills" class="filter-rbtn" <?php if(isset($params['group_by']) && $params['group_by'] == 'skills') { ?> checked <?php } ?> /> Skills <i class="btn btn-info btn-sm fa fa-info" data-toggle="tooltip" data-placement="top" title="Skills will be listed in the 1st column and list of developers that have this skill will be in the 2nd column."></i></li>
                <li><input type="radio" name="group_by" value="proficiency" class="filter-rbtn" <?php if(isset($params['group_by']) && $params['group_by'] == 'proficiency') { ?> checked <?php } ?> /> Proficiency <i class="btn btn-info btn-sm fa fa-info" data-toggle="tooltip" data-placement="top" title="Proficiency will be listed in the 1st column, list of developers in the 2nd column along with skill(s) in which they have this level of proficiency in parentheses next to their name."></i></li>
            </ul>

            - Limit results: <i class="btn btn-info btn-sm fa fa-info" data-toggle="tooltip" data-placement="top" title="This only limits the number of results displayed. It does not create pagination if there are more results to be displayed."></i>
            <ul>
                <li><input type="radio" name="limit" value="select" class="filter-rbtn" <?php if(isset($params['limit-s'])) { ?> checked <?php } ?> /> Select Limit <select name="limit_results" class="filter-input">
                        <option value="5" <?php if(isset($params['limit-s']) && $params['limit-s'] == 5) { ?> selected <?php } ?>>5</option>
                        <option value="10" <?php if(isset($params['limit-s']) && $params['limit-s'] == 10) { ?> selected <?php } ?>>10</option>
                        <option value="20" <?php if(isset($params['limit-s']) && $params['limit-s'] == 20) { ?> selected <?php } ?>>20</option>
                        <option value="50" <?php if(isset($params['limit-s']) && $params['limit-s'] == 50) { ?> selected <?php } ?>>50</option>
                        <option value="100" <?php if(isset($params['limit-s']) && $params['limit-s'] == 100) { ?> selected <?php } ?>>100</option>
                        <option value="0" <?php if(isset($params['limit-s']) && $params['limit-s'] == 0) { ?> selected <?php } ?>>- No limit -</option>
                    </select></li>
                <li><input type="radio" name="limit" value="custom" class="filter-rbtn" <?php if(isset($params['limit-c'])) { ?> checked <?php } ?> /> Custom limit (number): <input type="text" name="custom_limit" size="3" maxlength="5" class="filter-input" value="<?php echo (isset($params['limit-c'])) ? $params['limit-c'] : ''; ?>" /></li>
            </ul>
            <hr/>
            <strong>SEARCH</strong> <i class="btn btn-info btn-sm fa fa-info" data-toggle="tooltip" data-placement="top" title="1. Search (Ajax) - 'seamless' search, no page refresh. 2. Search (Submit) - search with page refresh and URL that contains search criteria. 3. Reset Form - resets form and clears selection"></i>
            <div id="search-container" class="py-4 text-center">
                <button type="button" class="btn btn-primary btn-lg" id="search-ajax-btn">Search (Ajax)</button>
                <button type="submit" class="btn btn-primary btn-lg">Search (Submit)</button>
            </div>
            <br />
            <div class="text-center">
                <button type="reset" class="btn btn-warning btn-sm">Reset Form</button>
            </div>
        </div>
    </div>
    <input type="hidden" name="token" value="<?php echo isset($_SESSION['token']) ? $_SESSION['token']['value'] : ''; ?>" />
</form>