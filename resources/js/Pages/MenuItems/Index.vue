<template>
    <div>
        <h1>Menu Items</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="menuItem in menuItems" :key="menuItem.id">
                    <td>{{ menuItem.name }}</td>
                    <td>{{ menuItem.category.name }}</td>
                    <td>{{ menuItem.description }}</td>
                    <td>{{ menuItem.price }}</td>
                    <td>{{ menuItem.created_at }}</td>
                    <td>{{ menuItem.updated_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        menuItems: Array,
    },
};
</script>