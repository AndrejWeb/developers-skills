<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'):

   $data = json_decode($_POST['json'], true);
   $results_by = $data['results_by'];

   $title = '';
   switch($results_by) {
       case 'developers':
           $title = $data['DeveloperName'];
           break;

       case 'skills':
           $title = 'Skills';
           break;

       case 'proficiency':
           $title = 'Proficiency - ' . $data['Proficiency'];
           break;
   }

?>
<?php if($data): ?>
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?php echo $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-dark">
                    <thead>
                    <?php if($results_by == 'developers'): ?>
                        <tr>
                            <th>#</th>
                            <th>Skill</th>
                            <th style="text-align: center;">Proficiency</th>
                            <th>Note</th>
                        </tr>
    <?php elseif($results_by == 'skills'): ?>
                        <tr>
                            <th>#</th>
                            <th>Skill ID</th>
                            <th>Skill Name</th>
                            <th>Developer</th>
                            <th>Proficiency</th>
                        </tr>
    <?php elseif($results_by == 'proficiency'): ?>
                        <tr>
                            <th>#</th>
                            <td>Developer</td>
                            <td>Skills with proficiency level <?php echo $data['Proficiency']; ?></td>
                        </tr>
    <?php endif; ?>
                    </thead>
                    <tbody>
                    <?php
                    if($results_by == 'developers') {
                        $skills = explode(',', $data['Skills']);
                        $proficiencies = explode(',', $data['Proficiencies']);
                        $notes = explode('---', $data['Notes']);
                        if($skills) {
                            $i = 1;
                            foreach($skills as $index => $skill) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $skill; ?></td>
                                    <td style="text-align: center;"><?php echo (isset($proficiencies[$index])) ? $proficiencies[$index] : ''; ?></td>
                                    <td><?php echo (isset($notes[$index])) ? $notes[$index] : ''; ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                    } else if($results_by == 'skills') {
                        $developers = explode(',', $data['Developers']);
                        $proficiencies = explode(',',$data['Proficiencies']);
                        $i = 1;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $data['SkillID']; ?></td>
                            <td><?php echo $data['Skill']; ?></td>
                            <td>
                                <?php if($developers) {
                                    foreach($developers as $key => $developer) {
                                        echo ($key + 1) . '. ' . $developer . '<br />';
                                    } ?>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;"><?php
                                foreach($proficiencies as $proficiency) echo $proficiency . '<br />';
                                ?></td>
                        </tr>
                        <?php
                    } else if($results_by == 'proficiency') {
                        $developers = array_combine(explode(',', $data['DevelopersID']), explode(',', $data['Developers']));

                        $developer_skills = [];

                        $developers_ids = explode(',', $data['DevelopersIDs']);
                        $skills = explode(',', $data['Skills']);

                        foreach($developers_ids as $index => $developer_id) {
                            if(isset($skills[$index])) {
                                $developer_skills[$developer_id][] = $skills[$index];
                            }
                        }

                        $i = 1;
                        foreach($developers as $index => $name) {
                        ?>
                        <tr>

                            <td><?php echo $i; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo implode('<br />', $developer_skills[$index]); ?></td>
                        </tr>
                        <?php
                            $i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>