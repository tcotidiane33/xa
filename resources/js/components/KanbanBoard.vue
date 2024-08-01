// resources/js/components/KanbanBoard.vue

<template>
    <div class="kanban-board">
        <div v-for="column in columns" :key="column.status" class="kanban-column">
            <h2>{{ column.title }}</h2>
            <div v-for="ticket in column.tickets" :key="ticket.id" class="kanban-card">
                <h3>{{ ticket.title }}</h3>
                <p>{{ ticket.description }}</p>
                <img v-if="ticket.image_path" :src="'/storage/' + ticket.image_path" alt="Screenshot">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            columns: [
                { status: 'new', title: 'Nouveaux', tickets: [] },
                { status: 'in_progress', title: 'En cours', tickets: [] },
                { status: 'done', title: 'Terminé', tickets: [] },
            ]
        };
    },
    mounted() {
        this.fetchTickets();
    },
    methods: {
        fetchTickets() {
            // Requête AJAX pour obtenir les tickets
            axios.get('/api/tickets').then(response => {
                this.columns.forEach(column => {
                    column.tickets = response.data.filter(ticket => ticket.status === column.status);
                });
            });
        }
    }
};
</script>

<style>
.kanban-board {
    display: flex;
    gap: 20px;
}
.kanban-column {
    flex: 1;
    background: #f4f4f4;
    padding: 10px;
    border-radius: 5px;
}
.kanban-card {
    background: #fff;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
</style>
