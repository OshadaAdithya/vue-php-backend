<template>
    
    <div class="centered-container">
        <div class="set1">
        
        <img alt="todo" class="todo" src="../assets/todo.png" width="100" height="100" />
        <h1>Task List</h1>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            <input type="text" placeholder="Type something" class="form-control" v-model="task_item">
            <button @click="submitTask" class="btn btn-primary">Submit</button>
            <button @click="deleteAll" class="btn btn-danger">Clear</button>
        </div>
        <div class="check" v-if="showWarning">
            <p>Please enter something!!!</p>
        
        </div>
        
        <div class="list">
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                <th scope="col" style="width:60px">id</th>
                <th scope="col">Task</th>
                <th scope="col" style="width: 180px;">Status</th>
                <th scope="col" style="width: 80px;" class="text-center">#</th>
                <th scope="col" style="width: 80px;" class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="todo in tasks" :key="todo.id">
                <td>{{ todo.id }}</td>
            <td>
                <template v-if="!todo.editing">{{ todo.task }}</template>
                <input type="text" v-else v-model="todo.task" @keyup.enter="saveTask(todo)">
                
            </td>
            <td>
                <select v-model="todo.status">
                    <option value="I">In-Progress</option>
                    <option value="D">Done</option>
                    <option value="T">To-Do</option>
                </select>
                
            </td>
            <td>
                <div class="text-center" @click="editTask(todo)">
                <span class="fa fa-edit"></span>
                </div>
            </td>
            <td>
                <div class="text-center" @click="deleteTask(todo)">
                <span class="fa fa-trash-alt"></span>
                </div>
            </td>   
            </tr>
    
            </tbody>
        </table>
        
        <button @click="updateStatus(todo)" class="btn btn-success">Save</button>
        
        </div>
    </div>

</template>

<script>
import { ref , onMounted} from 'vue';
export default {
    setup(){
        const tasks= ref([]);
        const task_item= ref('');
        const showWarning= ref(false);

        const fetchRecords= async ()=>{
            try{
                
                const response= await fetch("http://localhost:8080/vue-php/vue-php/src/PHP/fetch.php");
           
                //const data = await response.json();
                if (response.ok) {
                   
                    const data = await response.json();
                    tasks.value = data;
                    console.log(data);
                } else {
                    console.log('Error fetching records:', response.statusText);

                }
            }catch(error){
                console.error("Error:", error);

            }
        }
        onMounted(fetchRecords)

        const submitTask=async ()=>{
           

            try {
                if (task_item.value.trim() === ''){
                    showWarning.value=true;
                   
                }
                else{

                    const newTask={
                        taskName: task_item.value,
                        status_pass: 'T'

                    }
                    console.log(newTask)

                    console.log('before fetch api')
                    const response = await fetch("http://localhost:8080/vue-php/vue-php/src/PHP/create.php",{
                    method: 'POST',
                    body: JSON.stringify(newTask),

                    })
                    console.log('after fetch api')
                    
                    if (response.ok){
                        console.log('response ok success')
                        fetchRecords();
                        
                    }
                    else {
                        
                        console.error('Error saving task:', response.statusText);
                    }
                    task_item.value=''
                    showWarning.value=false;
 
            }

               
            } catch (error) {
                console.error('Error saving task:', error);
            }

        }

        //onMounted(submitTask);
        const editTask = (todo) => {
        
            todo.editing=true;
        }
    

        const saveTask =async (todo) => {
       
            try{
            if( todo.task.trim() !== '') {
                todo.editing=false;

                const response = await fetch("http://localhost:8080/vue-php/vue-php/src/PHP/update.php",{
                    method: 'POST',
                    body: JSON.stringify(
                        {
                            id: todo.id,
                            taskName: todo.task,
                            status_pass: todo.status
                        }
                    ),

                });

                if(response.ok){
                    todo.editing = false;
                    fetchRecords();
                }
                else {
                        
                    console.error('Error saving task:', response.statusText);
                }

            }
            } catch (error) {
                    console.error('Error saving task:', error);
            }
        }

        const deleteTask = async (todo) => {
       
        try{
            const response = await fetch("http://localhost:8080/vue-php/vue-php/src/PHP/delete.php",{
                method: 'POST',
                body: JSON.stringify(
                    {
                        id: todo.id,
                    }
                ),
                

            })

            if(response.ok){
                fetchRecords();
            }
            else {
                        
                console.error('Error saving task:', response.statusText);
            }

            }catch (error) {
                    console.error('Error saving task:', error);
            }


        }

        const deleteAll=() =>{
            tasks.value=[]

        }

        const updateStatus=async (todo) =>{
            try{
                const response = await fetch("http://localhost:8080/vue-php/vue-php/src/PHP/status.php",{
                method: 'POST',
                body: JSON.stringify(
                    {
                        id: todo.id,
                        status_pass: todo.status
                    }
                ),

            })

            if(response.ok){
                fetchRecords();
            }
            else {
                        
                console.error('Error saving task:', response.statusText);
            }
            }catch (error) {
                    console.error('Error saving task:', error);
            }
        }

        return{tasks, task_item, showWarning, submitTask, editTask, saveTask, deleteTask, deleteAll,fetchRecords,updateStatus}
    }
    
}


</script>

<style scoped>
.set1{
    text-align: center;
    margin: 0 auto;
    font-style: italic; 
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    padding-bottom: 15px;
}
.centered-container{
    width: 80%; 
    max-width: 800px;
    margin: 0 auto;
}

.check{
  color: red;
  margin-top: 10px;
}
    

</style>