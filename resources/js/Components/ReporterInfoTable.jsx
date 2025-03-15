import React, { useEffect, useState } from "react";
import { supabase } from "../supabaseClient";

const ReporterInfoTable = () => {
    const [reporters, setReporters] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchReporters = async () => {
            setLoading(true);
            try {
                const { data, error } = await supabase
                    .from("reporter_info")
                    .select("id, incident_reporter_name, incident_suspect_name, created_at, updated_at, method_id, resident_id, user_id, email, phone_number");
                
                if (error) throw error;
                
                setReporters(data);
            } catch (err) {
                setError(err.message);
                console.error("Error fetching reporter info:", err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchReporters();
    }, []);

    if (loading) return <p>Loading reporter information...</p>;
    if (error) return <p>Error: {error}</p>;

    return (
        <div>
            <h2>Reporter Information</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reporter Name</th>
                        <th>Suspect Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Method ID</th>
                        <th>Resident ID</th>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    {reporters.map((reporter) => (
                        <tr key={reporter.id}>
                            <td>{reporter.id}</td>
                            <td>{reporter.incident_reporter_name}</td>
                            <td>{reporter.incident_suspect_name}</td>
                            <td>{new Date(reporter.created_at).toLocaleString()}</td>
                            <td>{new Date(reporter.updated_at).toLocaleString()}</td>
                            <td>{reporter.method_id}</td>
                            <td>{reporter.resident_id}</td>
                            <td>{reporter.user_id}</td>
                            <td>{reporter.email}</td>
                            <td>{reporter.phone_number}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default ReporterInfoTable;
