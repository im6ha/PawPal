export function showNotification(title, message, type = 'success') {
    const modalHtml = `
        <div id="custom-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; font-family: 'Poppins', sans-serif;">
            <div style="background: white; padding: 2rem; border-radius: 12px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                <h2 style="margin-bottom: 0.5rem; color: ${type === 'success' ? '#2ecc71' : '#e63946'};">${title}</h2>
                <p style="color: #666; margin-bottom: 1.5rem;">${message}</p>
                <button id="modal-close" style="background: #007bff; color: white; border: none; padding: 0.8rem 2rem; border-radius: 6px; cursor: pointer; font-weight: 600;">OK</button>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);

    return new Promise((resolve) => {
        document.getElementById('modal-close').addEventListener('click', () => {
            document.getElementById('custom-modal').remove();
            resolve();
        });
    });
}





export async function Confirm(message) {
    return new Promise((resolve) => {
        const overlay = document.createElement('div');
        Object.assign(overlay.style, {
            position: 'fixed', top: '0', left: '0', width: '100%', height: '100%',
            backgroundColor: 'rgba(0,0,0,0.6)', display: 'flex', justifyContent: 'center',
            alignItems: 'center', zIndex: '2000', fontFamily: "'Montserrat', sans-serif"
        });

        const box = document.createElement('div');
        Object.assign(box.style, {
            backgroundColor: 'white', padding: '25px', borderRadius: '15px',
            textAlign: 'center', maxWidth: '350px', width: '90%', boxShadow: '0 10px 25px rgba(0,0,0,0.2)'
        });

        box.innerHTML = `
            <h3 style="margin-bottom: 15px; color: #333;">Confirm Action</h3>
            <p style="margin-bottom: 25px; color: #666; line-height: 1.5;">${message}</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button id="confirm-no" style="padding: 10px 20px; border-radius: 8px; border: 1px solid #ddd; background: #f5f5f5; cursor: pointer; font-weight: 600;">Cancel</button>
                <button id="confirm-yes" style="padding: 10px 20px; border-radius: 8px; border: none; background: #ff4d4d; color: white; cursor: pointer; font-weight: 600;">Delete</button>
            </div>
        `;

        overlay.appendChild(box);
        document.body.appendChild(overlay);

        document.getElementById('confirm-yes').onclick = () => {
            document.body.removeChild(overlay);
            resolve(true);
        };
        document.getElementById('confirm-no').onclick = () => {
            document.body.removeChild(overlay);
            resolve(false);
        };
    });
}