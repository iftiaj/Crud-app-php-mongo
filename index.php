<?php
//create the manager with default server address
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
// 查询数据
$filter = [
    // 'x' => ['$gt' => 0]
];
$options = [
    'projection' => ['_id' => 0]
// 'limit' => 5,
];
$query = new MongoDB\Driver\Query($filter, $options);
$result = $manager->executeQuery('admin.user', $query);
$data = [];
// var_dump($result);
foreach ($result as $v) {
    $data[] = $v;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IM Assignment</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="./static/bootstrap/css/bootstrap.css">
</head>
<body>

<div class="container">
    <!-- Section 1 -->
    <section class="section-1" id="home">
        <nav class="navbar">
            <a href="#home" class="navbar-link">Home</a>
            <a href="#customers" class="navbar-link">Crud</a>
            <a href="#team" class="navbar-link">Team</a>
            <a href="#contact" class="navbar-link">Contact</a>
        </nav>
        <div class="floating-bg"></div>
        <h1 class="section-1-heading">IM Assignment</h1>
        <div class="logo">
            <i class="fas fa-bezier-curve"></i>
        </div>
    </section>
    <!-- End of Section 1 -->

    <!-- Section 2 -->
    <section class="section-2" id="customers">
        <h1 class="section-heading">CRUD</h1>

        <div class="panel panel-default" style="width: 80%;margin: 20px auto;">
            <!-- Default panel contents -->
            <div class="panel-heading text-center" style="font-weight: bolder" >
                CRUD Panel
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModel" style="margin-top:-5px">add</button>
            </div>

            <!-- Table -->
            <table class="table">
                <thead>
                <th>
                <td>Name</td>
                <td>Address</td>
                <td>Phone</td>
                <td>Action</td>
                </th>
                </thead>
                <tbody>
                <?php foreach($data as $i => $item) { ?>
                    <tr>
                        <td>
                            <?php echo $i ?>
                        </td>
                        <td>
                            <?php echo $item->name ?>
                        </td>
                        <td>
                            <?php echo $item->address ?>
                        </td>
                        <td>
                            <?php echo $item->phone ?>
                        </td>
                        <td >
                            <button type="button" <?php echo "onclick=\"edit('".$item->name."','".$item->address."','".$item->phone."')\"" ?> class="btn btn-primary" >edit</button>
                            <button type="button" onclick="del('<?php echo $item->name ?>')" class="btn btn-primary" >delete</button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>


        <div class="modal fade" id="addModel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <form id="addForm">
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="text" class="form-control" id="name" placeholder="name">
                            </div>
                            <div class="form-group">
                                <label for="address">address</label>
                                <input type="text" class="form-control" id="address" placeholder="address">
                            </div>
                            <div class="form-group">
                                <label for="phone">phone</label>
                                <input type="number" class="form-control" id="phone" placeholder="phone">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="addSubmit" class="btn btn-primary">submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade" id="editModel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">edit user</h4>
                    </div>
                    <form id="editForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">name</label>
                                <input type="text" disabled class="form-control" id="name" placeholder="name">
                            </div>
                            <div class="form-group">
                                <label for="address">address</label>
                                <input type="text" class="form-control" id="address" placeholder="address">
                            </div>
                            <div class="form-group">
                                <label for="phone">phone</label>
                                <input type="number" class="form-control" id="phone" placeholder="phone">
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="editSubmit" class="btn btn-primary">submit</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://fastly.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="./static/bootstrap/js/bootstrap.js" ></script>

<script>
    $('#addSubmit').click(function(){
        $('#addModel').modal('hide')
        const inputNode = $('#addForm input')
        const pData = {
            'name': $(inputNode[0]).val(),
            'address': $(inputNode[1]).val(),
            'phone': $(inputNode[2]).val(),
        }
        console.log(pData)
        $.post({url: '/add.php', data:pData, success(res){
                console.log(res)
                alert('添加成功')
                location.reload()
            },
            error(err) {
                alert('添加失败')
            }
        })
        return false;
    })

    $('#editSubmit').click(function(){
        $('#editModel').modal('show')
        const name = $('#editForm input#name').val()
        const address = $('#editForm input#address').val()
        const phone = $('#editForm input#phone').val()
        console.log(phone)
        const pdata = {
            name: name,
            address: address,
            phone: phone
        }

        $.post({
            url: 'update.php',
            data: pdata,
            success(res) {
                console.log(res)
                alert('更新成功')
                location.reload()
            },
            error(err) {
                alert(err)
            }
        })
    })

    function edit(name, address, phone) {
        $('#editForm input#name').val(name)
        $('#editForm input#address').val(address)
        $('#editForm input#phone').val(phone)
        $('#editModel').modal('show')
        console.log(phone)
    }

    function del(name) {
        $.get({
            url: '/del.php?name='+name,
            success(res) {
                console.log(res)
                alert('删除成功')
                location.reload()
            },
            error(err) {
                alert(err)
            }
        })
    }
</script>

</section>
<!-- End of Section 2 -->

<!-- Section 3 -->
<section class="section-3" id="team">
    <h1 class="section-heading">Team</h1>
    <div class="team-wrapper">
        <div class="team-member">
            <img src="images/team-member-1.jpg" class="team-member-img">
            <h2 class="team-member-name"> Eng Zhong Han <span>(Frontend dev)</span></h2>
            <ul class="team-member-skills">
                <li>PHP</li>
                <li>Figma</li>
                <li>HTML5</li>
                <li>CSS3</li>
                <li>Ai</li>
            </ul>
            <a href="#" class="projects-btn">Projects</a>
            <div class="story-btn" title="My Story">
                <div class="story-btn-line"></div>
            </div>
            <div class="story">
                <h4 class="story-heading">About Me</h4>
                <p class="story-paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit obcaecati blanditiis aspernatur ab doloribus optio nesciunt adipisci fugiat quia veritatis doloremque tempore ipsum sunt atque exercitationem perspiciatis, beatae aliquam voluptates perferendis. Doloribus exercitationem adipisci, quidem veritatis temporibus magni. Sunt, exercitationem?</p>
            </div>
        </div>
        <div class="team-member">
            <img src="images/team-member-2.jpg" class="team-member-img">
            <h2 class="team-member-name">Iftiaj Alom <span>(Backend dev)</span></h2>
            <ul class="team-member-skills">
                <li>PHP</li>
                <li>ReactJS</li>
                <li>NodeJS</li>
                <li>MongoDB</li>
                <li>Python</li>
            </ul>
            <a href="#" class="projects-btn">Projects</a>
            <div class="story-btn" title="My Story">
                <div class="story-btn-line"></div>
            </div>
            <div class="story">
                <h4 class="story-heading">About Me</h4>
                <p class="story-paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit obcaecati blanditiis aspernatur ab doloribus optio nesciunt adipisci fugiat quia veritatis doloremque tempore ipsum sunt atque exercitationem perspiciatis, beatae aliquam voluptates perferendis. Doloribus exercitationem adipisci, quidem veritatis temporibus magni. Sunt, exercitationem?</p>
            </div>
        </div>
        <div class="team-member">
            <img src="images/team-member-3.jpg" class="team-member-img">
            <h2 class="team-member-name">Lin Ke <span>(Database Admin)</span></h2>
            <ul class="team-member-skills">
                <li>PHP</li>
                <li>ReactJS</li>
                <li>NodeJS</li>
                <li>MongoDB</li>
                <li>Python</li>
            </ul>
            <a href="#" class="projects-btn">Projects</a>
            <div class="story-btn" title="My Story">
                <div class="story-btn-line"></div>
            </div>
            <div class="story">
                <h4 class="story-heading">About Me</h4>
                <p class="story-paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit obcaecati blanditiis aspernatur ab doloribus optio nesciunt adipisci fugiat quia veritatis doloremque tempore ipsum sunt atque exercitationem perspiciatis, beatae aliquam voluptates perferendis. Doloribus exercitationem adipisci, quidem veritatis temporibus magni. Sunt, exercitationem?</p>
            </div>
        </div>
    </div>
</section>
<!-- End of Section 3 -->

<!-- Section 4 -->
<section class="section-4" id="contact">
    <h1 class="section-heading">Contact</h1>
    <div class="form-container">
        <img src="images/form-img.png" class="form-img">
        <form class="contact-form">
            <input type="text" placeholder="Your Name">
            <input type="email" placeholder="Your Email">
            <textarea placeholder="Your Message"></textarea>
            <input type="submit" value="Send">
        </form>
    </div>
    <p class="copyright">
        Copyright &copy; Iftiaj and co. All Rights Reserved
    </p>
</section>
<!-- End of Section 4 -->

<a href="#home" class="scroll-up-btn">
    <i class="fas fa-arrow-up"></i>
</a>
</div>

<script src="script.js"></script>
</body>
</html>