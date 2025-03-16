// src/components/App.jsx

import React, { useState, useEffect } from 'react';
import IncidentTable from "./IncidentTable";
import IncidentViewOnlyTable from "./IncidentViewOnlyTable";
import { supabase } from "../supabaseClient"; // Corrected path
import PropTypes from 'prop-types';

const App = () => {
    const [incidents, setIncidents] = useState([]);
    const [statuses, setStatuses] = useState([]);
    const [methods, setMethods] = useState([]);
    const [incidentTypes, setIncidentTypes] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [viewMode, setViewMode] = useState(true);

    const [searchQuery, setSearchQuery] = useState("");
    const [filterStatus, setFilterStatus] = useState("");
    const [filterMethod, setFilterMethod] = useState("");
    const [filterIncidentType, setFilterIncidentType] = useState("");
    const [filterYear, setFilterYear] = useState("");
    const [filterMonth, setFilterMonth] = useState("");
    const [filterDay, setFilterDay] = useState("");

    useEffect(() => {
        const fetchData = async () => {
            setLoading(true);
            try {
                const { data: incidentData, error: incidentError } = await supabase
                    .from("incidents")
                    .select(`
                      incident_id,
                      description,
                      date_reported,
                      location,
                      address,
                      update_id,
                      reporter_id,
                      incident_updates!incidents_update_id_fkey(
                        details,
                        status:status_updateid(status)
                      ),
                      incident_type!incidents_incidentType_id_fkey(
                        incidentType
                      ),
                      reporter_info!incidents_reporter_id_fkey(
                        incident_reporter_name,
                        phone_number,
                        incident_suspect_name,
                        method:method_id(methodType)
                      )
                    `)
                    .order("date_reported", { ascending: false });

                if (incidentError) throw incidentError;
                setIncidents(incidentData);

                const { data: statusData, error: statusError } = await supabase
                    .from("status")
                    .select("status");

                if (statusError) throw statusError;
                setStatuses(statusData.map(s => s.status));

                const { data: methodData, error: methodError } = await supabase
                    .from("method")
                    .select("methodType");

                if (methodError) throw methodError;
                setMethods(methodData.map(m => m.methodType));

                const { data: incidentTypeData, error: incidentTypeError } = await supabase
                    .from("incident_type")
                    .select("incidentType");

                if (incidentTypeError) throw incidentTypeError;
                setIncidentTypes(incidentTypeData.map(it => it.incidentType));
            } catch (err) {
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    const filteredIncidents = incidents.filter((incident) => {
        const matchesSearch =
            searchQuery === "" ||
            incident.description.toLowerCase().includes(searchQuery.toLowerCase()) ||
            incident.reporter_info?.incident_reporter_name?.toLowerCase().includes(searchQuery.toLowerCase()) ||
            incident.reporter_info?.incident_reported_name?.toLowerCase().includes(searchQuery.toLowerCase()) ||
            incident.update_id?.toLowerCase().includes(searchQuery.toLowerCase());

        const matchesStatus = filterStatus === "" || (incident.incident_updates?.status?.status === filterStatus);
        const matchesMethod = filterMethod === "" || (incident.reporter_info?.method?.methodType === filterMethod);
        const matchesIncidentType = filterIncidentType === "" || (incident.incident_type?.incidentType === filterIncidentType);

        const incidentDate = new Date(incident.date_reported);
        const incidentYear = incidentDate.getFullYear().toString();
        const incidentMonth = (incidentDate.getMonth() + 1).toString().padStart(2, "0");
        const incidentDay = incidentDate.getDate().toString().padStart(2, "0");

        const matchesYear = filterYear === "" || incidentYear === filterYear;
        const matchesMonth = filterMonth === "" || incidentMonth === filterMonth;
        const matchesDay = filterDay === "" || incidentDay === filterDay;

        return matchesSearch && matchesStatus && matchesMethod && matchesIncidentType && matchesYear && matchesMonth && matchesDay;
    });


    const viewOnlyIncidents = filteredIncidents;

    const editableIncidents = filteredIncidents.filter((incident) => {
        const status = incident.incident_updates?.status?.status;
        return status && ["Pending", "In-Progress", "Completed"].includes(status);
    });

    if (loading) return <p>Loading incidents...</p>;
    if (error) return <p className="text-red-500">Error: {error}</p>;

    return (
        <div className="container mx-auto mt-8">
            <div className="flex justify-between items-center mb-4">
                <h1 className="text-3xl font-bold text-center text-white bg-gray-800 px-4 py-2 rounded-lg">
                    {viewMode ? "View Incidents" : "Manage Incidents"}
                </h1>

                <button
                    onClick={() => setViewMode(!viewMode)}
                    className="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md"
                >
                    {viewMode ? "Switch to Edit Mode" : "Switch to View Mode"}
                </button>
            </div>

            <div className="flex flex-nowrap gap-2 mb-4 overflow-x-auto">
                <input
                    type="text"
                    placeholder="Search tracking number or name"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full sm:w-1/3"
                />

                <select
                    value={filterYear}
                    onChange={(e) => setFilterYear(e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full sm:w-1/4"
                >
                    <option value="">Filter by Year</option>
                    {Array.from(new Set(incidents.map(i => new Date(i.date_reported).getFullYear()))).map(year => (
                        <option key={year} value={year}>{year}</option>
                    ))}
                </select>

                <select
                    value={filterMonth}
                    onChange={(e) => setFilterMonth(e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full sm:w-1/4"
                >
                    <option value="">Filter by Month</option>
                    {Array.from({ length: 12 }, (_, i) => (i + 1).toString().padStart(2, "0")).map(month => (
                        <option key={month} value={month}>{month}</option>
                    ))}
                </select>

                <select
                    value={filterDay}
                    onChange={(e) => setFilterDay(e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full sm:w-1/4"
                >
                    <option value="">Filter by Day</option>
                    {Array.from({ length: 31 }, (_, i) => (i + 1).toString().padStart(2, "0")).map(day => (
                        <option key={day} value={day}>{day}</option>
                    ))}
                </select>
            </div>

            <div className="flex flex-nowrap gap-2 mb-4 overflow-x-auto">

                <select
                    value={filterMethod}
                    onChange={(e) => setFilterMethod(e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full sm:w-1/4"
                >
                    <option value="">Filter by Method</option>
                    {methods.map((method) => (
                        <option key={method} value={method}>{method}</option>
                    ))}
                </select>

                <select
                    value={filterIncidentType}
                    onChange={(e) => setFilterIncidentType(e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full sm:w-1/4"
                >
                    <option value="">Filter by Incident Type</option>
                    {incidentTypes.map((type) => (
                        <option key={type} value={type}>{type}</option>
                    ))}
                </select>


                <select
                    value={filterStatus}
                    onChange={(e) => setFilterStatus(e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full sm:w-1/4"
                >
                    <option value="">Filter by Status</option>
                    {statuses.map((status) => (
                        <option key={status} value={status}>{status}</option>
                    ))}
                </select>

            </div>

            {viewMode ? (
                <IncidentViewOnlyTable incidents={viewOnlyIncidents} />
            ) : (
                <IncidentTable incidents={editableIncidents} />
            ) }
        </div>
    );
};

App.propTypes = {

};

export default App;