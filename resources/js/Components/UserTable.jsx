import React, { useState, useEffect } from 'react';
import { supabase } from "../supabaseClient";

const UserTable = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchUsers = async () => {
            const { data, error } = await supabase.from("users").select("id, name, email, role_id");
            if (error) console.error(error);
            else setUsers(data);
            setLoading(false);
        };
        fetchUsers();
    }, []);

    const updateRole = async (userId, newRole) => {
        const { error } = await supabase
            .from("users")
            .update({ role_id: newRole })
            .eq("id", userId);

        if (error) console.error("Error updating role:", error);
        else {
            setUsers(users.map(user => (user.id === userId ? { ...user, role_id: newRole } : user)));
        }
    };

    if (loading) return <p>Loading users...</p>;

    return (
        <div className="bg-white p-4 rounded shadow-md">
            <h2 className="text-xl font-bold mb-4">Edit User Roles</h2>
            <table className="w-full border-collapse border border-gray-300">
                <thead>
                    <tr className="bg-gray-200">
                        <th className="border p-2">ID</th>
                        <th className="border p-2">Name</th>
                        <th className="border p-2">Email</th>
                        <th className="border p-2">Role</th>
                    </tr>
                </thead>
                <tbody>
                    {users.map(user => (
                        <tr key={user.id} className="border">
                            <td className="border p-2">{user.id}</td>
                            <td className="border p-2">{user.name}</td>
                            <td className="border p-2">{user.email}</td>
                            <td className="border p-2">
                                <select
                                    value={user.role_id}
                                    onChange={(e) => updateRole(user.id, parseInt(e.target.value))}
                                    className="border rounded p-1"
                                >
                                    <option value="0">Resident</option>
                                    <option value="1">Admin1</option>
                                    <option value="2">Admin2</option>
                                    <option value="3">Admin3</option>
                                </select>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default UserTable;