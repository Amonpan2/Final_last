<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <title>TODO</title>
</head>

<body>
    <div class="container mt-3">
        <h2>TODO TODAY</h2>

        <button class = "btn btn-primary" onclick="addTodo()">Add TODO lists</button>


        {{--  table  --}}
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ลำดับที่</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">การกระทำ</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @if ($todo_lists !== null)
                    @foreach ($todo_lists as $index => $todo_list)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $todo_list->td_name }}</td>
                            <td>
                                @if ($todo_list->td_status === 0)
                                    ยังไม่ทำ
                                @else
                                    ทำแล้ว
                                @endif
                            </td>
                            <td class="d-flex gap-2">
                                <div style="cursor: pointer">✅</div>
                                <div style="cursor: pointer" onclick="editTodo({{ $todo_list->td_id }})">🖋️</div>
                                <div style="cursor: pointer" onclick="deleteTodo({{ $todo_list->td_id }})">🗑️</div>
                            </td>


                        </tr>
                    @endforeach
                @else
                    <p>Nope...</p>
                @endif



            </tbody>
        </table>
    </div>


</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
    const addTodo = () => {
        Swal.fire({
            title: "Todo list",
            html: '<input id="title" placeholder ="หัวข้อ" class="swal2-input">' +
                '<input id="des" placeholder ="คำอธิบาย" class="swal2-input">',

            showCancelButton: true,
            confirmButtonText: "สร้าง",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    //ดึงค่า
                    const title = document.getElementById("title").value;
                    const des = document.getElementById("des").value;
                    //ส่ง req
                    const response = await fetch('/todo', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title,
                            des
                        })
                    });
                    //ถ้า err
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: `เกิดข้อผิดพลาด`,
                    });
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    title: `สำเร็จ`,
                });

                window.location.reload(); // relode screen
            }
        });

    }
    const deleteTodo = async (td_id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await fetch(`/todo/${td_id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                });
                if (response.status === 200) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    window.location.reload();
                }
            }
        });
    }
    const editTodo = async (td_id) => {
        Swal.fire({
            title: "แก้ไข",
            html: '<input id="title" placeholder ="หัวข้อ" class="swal2-input">' +
                '<input id="des" placeholder ="คำอธิบาย" class="swal2-input">',

            showCancelButton: true,
            confirmButtonText: "สร้าง",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    //ดึงค่า
                    const name = document.getElementById("title").value;
                    const des = document.getElementById("des").value;
                    //ส่ง req
                    const response = await fetch(`/todo/${td_id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name,
                            des
                        })
                    });
                    //ถ้า err
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: `เกิดข้อผิดพลาด`,
                    });
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    title: `สำเร็จ`,
                });

                window.location.reload();
            }
        });

    }
    
</script>

</html>
