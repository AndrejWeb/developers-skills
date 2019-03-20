<?php defined('APP_NAME') || exit('No direct access allowed.'); ?>
<div class="row">
    <div class="col-sm">
        <h3>Data</h3>
        <?php if(isset($params)) { ?>
        Search criteria<br /><span class="badge badge-default">
            <?php foreach($params as $key => $value) {
                echo $key . ' => ' . $value . '<br />';
            } ?>
        </span>
            <br />
        <?php } ?>
        Total records <span class="badge badge-info"><?php echo ($data) ? count($data) : 0; ?></span>
        <br />
        <table class="table table-bordered">
            <thead class="thead-blue">
            <?php if($data): ?>
                <?php if($results_by == 'developers'): ?>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Dev Name</th>
                        <th scope="col">Skills</th>
                        <th scope="col">Count</th>
                        <th scope="col">Proficiencies</th>
                        <th scope="col">Details</th>
                    </tr>
                <?php elseif ($results_by == 'skills'): ?>
                    <tr>
                        <th scope="col">Skill ID</th>
                        <th scope="col">Skill</th>
                        <th scope="col">Developers</th>
                        <th scope="col">Count</th>
                        <th scope="col">Details</th>
                    </tr>
                <?php elseif($results_by == 'proficiency'): ?>
                    <tr>
                        <th scope="col">Proficiency</th>
                        <th scope="col">Developers</th>
                        <th scope="col">Count</th>
                        <th scope="col">Details</th>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
            </thead>
            <tbody class="bg-white">
            <?php if($data): ?>
                <?php if($results_by == 'developers'): ?>
                    <?php foreach($data as $item):
                        $item['results_by'] = $results_by;
                        ?>
                        <tr id="dev<?php echo $item['DeveloperID']; ?>">
                            <td><?php echo $item['DeveloperID']; ?></td>
                            <td><?php echo $item['DeveloperName']; ?></td>
                            <td><?php echo $item['Skills']; ?></td>
                            <td><?php echo $item['SkillsCount']; ?></td>
                            <td><?php echo $item['Proficiencies']; ?></td>
                            <td>
                                <a href="#" class="view-details">View</a>
                                <div class="item_json"><?php  echo json_encode($item); ?></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif($results_by == 'skills'): ?>
                    <?php foreach($data as $item):
                        $item['results_by'] = $results_by;
                        ?>
                        <tr id="dev<?php echo $item['SkillID']; ?>">
                            <td><?php echo $item['SkillID']; ?></td>
                            <td><?php echo $item['Skill']; ?></td>
                            <td><?php echo $item['Developers']; ?></td>
                            <td><?php echo $item['DevelopersCount']; ?></td>
                            <td>
                                <a href="#" class="view-details">View</a>
                                <div class="item_json"><?php echo json_encode($item); ?></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif($results_by == 'proficiency'): ?>
                    <?php foreach($data as $item):
                        $item['results_by'] = $results_by;
                        ?>
                        <tr id="dev<?php echo $item['Proficiency']; ?>">
                            <td><?php echo $item['Proficiency']; ?></td>
                            <td><?php echo $item['Developers']; ?></td>
                            <td><?php echo $item['DevelopersCount']; ?></td>
                            <td>
                                <a href="#" class="view-details">View</a>
                                <div class="item_json"><?php echo json_encode($item); ?></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>