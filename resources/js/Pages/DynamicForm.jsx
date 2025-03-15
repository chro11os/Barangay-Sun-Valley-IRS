import React, { useState } from 'react';

const DynamicForm = () => {
    const [formFields, setFormFields] = useState([{ name: '', value: '' }]);

    const handleChange = (index, event) => {
        const newFormFields = [...formFields];
        newFormFields[index][event.target.name] = event.target.value;
        setFormFields(newFormFields);
    };

    const handleAddField = () => {
        setFormFields([...formFields, { name: '', value: '' }]);
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        console.log('Form submitted:', formFields);
    };

    return (
        <form onSubmit={handleSubmit}>
            {formFields.map((field, index) => (
                <div key={index}>
                    <input
                        name="name"
                        placeholder="Field Name"
                        value={field.name}
                        onChange={(event) => handleChange(index, event)}
                    />
                    <input
                        name="value"
                        placeholder="Field Value"
                        value={field.value}
                        onChange={(event) => handleChange(index, event)}
                    />
                </div>
            ))}
            <button type="button" onClick={handleAddField}>
                Add Field
            </button>
            <button type="submit">Submit</button>
        </form>
    );
};

export default DynamicForm;
