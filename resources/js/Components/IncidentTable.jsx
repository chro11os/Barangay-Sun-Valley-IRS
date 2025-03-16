import React, { useState, useEffect } from "react";
import { supabase } from "../supabaseClient"; // Ensure Supabase is correctly configured

const IncidentTable = ({ incidents }) => {
  const [editingId, setEditingId] = useState(null);
  const [editValues, setEditValues] = useState({ status: "", description: "" });
  const [statusOptions, setStatusOptions] = useState([]);

  // Fetch available statuses
  useEffect(() => {
    const fetchStatuses = async () => {
      const { data, error } = await supabase.from("status").select("status_update_id, status");
      if (error) {
        console.error("Error fetching statuses:", error);
      } else {
        setStatusOptions(data);
      }
    };
    fetchStatuses();
  }, []);
 
  const fetchIncidents = async () => {
    const { data, error } = await supabase.from("incident_updates").select("*");
    if (error) {
      console.error("Error fetching incidents:", error);
    } else {
      setIncidents(data); // Assuming `setIncidents` is available in your parent component
    }
  };
  

  const handleEditClick = (incident) => {
    setEditingId(incident.incident_id);
    setEditValues({
      status: incident.incident_updates?.status?.status || "",
      description: incident.incident_updates?.details || "",
    });
  };

  const handleChange = (e) => {
    setEditValues({ ...editValues, [e.target.name]: e.target.value });
  };

  const handleSave = async (incident_id) => {
    const { status, description } = editValues;

    // Check if status is stored as an ID
    const selectedStatus = statusOptions.find((s) => s.status === status);
    if (!selectedStatus) {
      console.error("Invalid status selected:", status);
      alert("Invalid status. Please try again.");
      return;
    }
    const status_id = selectedStatus.status_update_id; // Use the correct column

    console.log("Updating Incident ID:", incident_id);
    console.log("New Status:", status);
    console.log("New Description:", description);
    console.log("Status ID (if applicable):", status_id);

    const { error } = await supabase
      .from("incident_updates")
      .update({
        status_updateid: status_id, // Ensure correct column name
        details: description,
      })
      .eq("incident_id", incident_id);

    if (error) {
      console.error("Error updating incident:", error);
      alert("Failed to update incident. Check console for details.");
    } else {
      alert("Incident updated successfully!");
      setEditingId(null); // Exit edit mode
    }
    fetchIncidents();

  };

  return (
    <div>
      <table className="min-w-full bg-white shadow-md rounded border border-gray-300 mt-4">
        <thead>
          <tr className="bg-gray-800 text-yellow-100 text-sm md:text-base">
            <th className="py-2 px-4">Tracking #</th>
            <th className="py-2 px-4">Method</th>
            <th className="py-2 px-4">Incident Type</th>
            <th className="py-2 px-4">Date Reported</th>
            <th className="py-2 px-4">Reporter</th>
            <th className="py-2 px-4">Reported</th>
            <th className="py-2 px-4">Incident Details</th>
            <th className="py-2 px-4">Status</th>
            <th className="py-2 px-4">Description</th>
            <th className="py-2 px-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          {incidents.length === 0 ? (
            <tr>
              <td colSpan="10" className="text-center py-4 text-gray-500">
                No incidents found
              </td>
            </tr>
          ) : (
            incidents.map((incident) => (
              <tr key={incident.incident_id} className="hover:bg-gray-100 text-sm md:text-base">
                <td className="border px-4 py-2">{incident.update_id}</td>
                <td className="border px-4 py-2">{incident.reporter_info?.method?.methodType || "N/A"}</td>
                <td className="border px-4 py-2">{incident.incident_type?.incidentType}</td>
                <td className="border px-4 py-2">{new Date(incident.date_reported).toLocaleString()}</td>
                <td className="border px-4 py-2">{incident.reporter_info?.incident_reporter_name || "N/A"}</td>
                <td className="border px-4 py-2">{incident.reporter_info?.incident_suspect_name || "N/A"}</td>
                <td className="border px-4 py-2">{incident.description}</td>

                {/* Status - Dropdown for Editing */}
                <td className="border px-4 py-2">
                  {editingId === incident.incident_id ? (
                    <select
                      name="status"
                      value={editValues.status}
                      onChange={handleChange}
                      className="border p-1 rounded"
                    >
                      {statusOptions.map((status) => (
                        <option key={status.status_update_id} value={status.status}>
                          {status.status}
                        </option>
                      ))}
                    </select>
                  ) : (
                    incident.incident_updates?.status?.status || "N/A"
                  )}
                </td>

                {/* Description - Editable */}
                <td className="border px-4 py-2">
                  {editingId === incident.incident_id ? (
                    <input
                      type="text"
                      name="description"
                      value={editValues.description}
                      onChange={handleChange}
                      className="border p-1 rounded"
                    />
                  ) : (
                    incident.incident_updates?.details || "N/A"
                  )}
                </td>

                <td className="border px-4 py-2 text-center">
                  {editingId === incident.incident_id ? (
                    <>
                      <button
                        onClick={() => handleSave(incident.incident_id)}
                        className="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded-md mr-2"
                      >
                        Save
                      </button>
                      <button
                        onClick={() => setEditingId(null)}
                        className="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded-md"
                      >
                        Cancel
                      </button>
                    </>
                  ) : (
                    <button
                      onClick={() => handleEditClick(incident)}
                      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded-md"
                    >
                      Edit
                    </button>
                  )}
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
};

export default IncidentTable;
