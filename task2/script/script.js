const newTaskInput = document.getElementById('new-task');
const addBtn = document.getElementById('add-btn');
const taskList = document.getElementById('task-list');
const taskCount = document.getElementById('task-count');
function updateTaskCount() 
{
	taskCount.textContent = `Tasks: ${taskList.children.length}`;
}
function createTaskElement(taskText) 
{
	const li = document.createElement('li');
	const span = document.createElement('span');
	span.textContent = taskText;
	span.addEventListener('click', () => 
	{
		li.classList.toggle('completed');
	});
	const deleteBtn = document.createElement('button');
	deleteBtn.textContent = 'Delete';
	deleteBtn.className = 'delete-btn';
	deleteBtn.addEventListener('click', () => 
	{
		taskList.removeChild(li);
		updateTaskCount();
	});
	li.appendChild(span);
	li.appendChild(deleteBtn);
	return li;
}
addBtn.addEventListener('click', () => 
{
	const taskText = newTaskInput.value.trim();
    if (taskText !== '') 
	{
        const taskElement = createTaskElement(taskText);
        taskList.appendChild(taskElement);
        newTaskInput.value = '';
        updateTaskCount();
    }
});
newTaskInput.addEventListener('keypress', (e) => 
{
    if (e.key === 'Enter') 
	{
        addBtn.click();
    }
});
updateTaskCount();